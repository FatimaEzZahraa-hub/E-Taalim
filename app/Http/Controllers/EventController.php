<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Afficher la liste des événements
     */
    public function index()
    {
        // Récupérer tous les événements
        $events = $this->getAllEvents();
        
        return view('admin.events.index', compact('events'));
    }
    
    /**
     * Afficher le formulaire de création d'événement
     */
    public function create()
    {
        // Récupérer la liste des utilisateurs pour les invitations
        $users = $this->getAllUsers();
        
        return view('admin.events.create', compact('users'));
    }
    
    /**
     * Enregistrer un nouvel événement
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'type' => 'required|in:public,private',
            'participants' => 'nullable|array',
            'participants.*' => 'integer'
        ]);
        
        // Combiner la date et l'heure
        $dateTime = Carbon::parse($request->input('date') . ' ' . $request->input('time'));
        
        // Créer l'événement
        $eventId = DB::table('events')->insertGetId([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'date_time' => $dateTime,
            'location' => $request->input('location'),
            'type' => $request->input('type'),
            'creator_id' => Auth::id(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        // Ajouter les participants si c'est un événement privé
        if ($request->input('type') === 'private' && $request->has('participants')) {
            $participants = $request->input('participants');
            
            foreach ($participants as $participantId) {
                DB::table('event_participants')->insert([
                    'event_id' => $eventId,
                    'user_id' => $participantId,
                    'status' => 'invited',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                
                // Envoyer une notification à chaque participant
                $this->sendEventNotification($eventId, $participantId, 'invitation');
            }
        }
        
        return redirect()->route('admin.events.index')->with('success', 'Événement créé avec succès');
    }
    
    /**
     * Afficher les détails d'un événement
     */
    public function show($id)
    {
        // Récupérer l'événement
        $event = $this->getEventById($id);
        
        if (!$event) {
            return redirect()->route('admin.events.index')->with('error', 'Événement non trouvé');
        }
        
        // Récupérer les participants
        $participants = $this->getEventParticipants($id);
        
        return view('admin.events.show', compact('event', 'participants'));
    }
    
    /**
     * Afficher le formulaire d'édition d'un événement
     */
    public function edit($id)
    {
        // Récupérer l'événement
        $event = $this->getEventById($id);
        
        if (!$event) {
            return redirect()->route('admin.events.index')->with('error', 'Événement non trouvé');
        }
        
        // Récupérer la liste des utilisateurs pour les invitations
        $users = $this->getAllUsers();
        
        // Récupérer les participants actuels
        $participants = $this->getEventParticipants($id);
        $participantIds = array_column($participants, 'id');
        
        return view('admin.events.edit', compact('event', 'users', 'participantIds'));
    }
    
    /**
     * Mettre à jour un événement
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'type' => 'required|in:public,private',
            'participants' => 'nullable|array',
            'participants.*' => 'integer'
        ]);
        
        // Récupérer l'événement
        $event = $this->getEventById($id);
        
        if (!$event) {
            return redirect()->route('admin.events.index')->with('error', 'Événement non trouvé');
        }
        
        // Combiner la date et l'heure
        $dateTime = Carbon::parse($request->input('date') . ' ' . $request->input('time'));
        
        // Mettre à jour l'événement
        DB::table('events')->where('id', $id)->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'date_time' => $dateTime,
            'location' => $request->input('location'),
            'type' => $request->input('type'),
            'updated_at' => Carbon::now()
        ]);
        
        // Mettre à jour les participants si c'est un événement privé
        if ($request->input('type') === 'private') {
            // Supprimer les participants actuels
            DB::table('event_participants')->where('event_id', $id)->delete();
            
            // Ajouter les nouveaux participants
            if ($request->has('participants')) {
                $participants = $request->input('participants');
                
                foreach ($participants as $participantId) {
                    DB::table('event_participants')->insert([
                        'event_id' => $id,
                        'user_id' => $participantId,
                        'status' => 'invited',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    
                    // Envoyer une notification à chaque nouveau participant
                    $this->sendEventNotification($id, $participantId, 'update');
                }
            }
        }
        
        return redirect()->route('admin.events.show', $id)->with('success', 'Événement mis à jour avec succès');
    }
    
    /**
     * Supprimer un événement
     */
    public function destroy($id)
    {
        // Récupérer l'événement
        $event = $this->getEventById($id);
        
        if (!$event) {
            return redirect()->route('admin.events.index')->with('error', 'Événement non trouvé');
        }
        
        // Supprimer les participants
        DB::table('event_participants')->where('event_id', $id)->delete();
        
        // Supprimer les notifications
        DB::table('notifications')->where('type', 'event')->where('entity_id', $id)->delete();
        
        // Supprimer l'événement
        DB::table('events')->where('id', $id)->delete();
        
        return redirect()->route('admin.events.index')->with('success', 'Événement supprimé avec succès');
    }
    
    /**
     * Inviter des participants à un événement
     */
    public function inviteParticipants(Request $request, $id)
    {
        $request->validate([
            'participants' => 'required|array',
            'participants.*' => 'integer'
        ]);
        
        // Récupérer l'événement
        $event = $this->getEventById($id);
        
        if (!$event) {
            return redirect()->route('admin.events.index')->with('error', 'Événement non trouvé');
        }
        
        // Ajouter les nouveaux participants
        $participants = $request->input('participants');
        
        foreach ($participants as $participantId) {
            // Vérifier si le participant est déjà invité
            $existing = DB::table('event_participants')
                ->where('event_id', $id)
                ->where('user_id', $participantId)
                ->first();
            
            if (!$existing) {
                DB::table('event_participants')->insert([
                    'event_id' => $id,
                    'user_id' => $participantId,
                    'status' => 'invited',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                
                // Envoyer une notification à chaque nouveau participant
                $this->sendEventNotification($id, $participantId, 'invitation');
            }
        }
        
        return redirect()->route('admin.events.show', $id)->with('success', 'Participants invités avec succès');
    }
    
    /**
     * Répondre à une invitation à un événement
     */
    public function respondToInvitation(Request $request, $id)
    {
        $request->validate([
            'response' => 'required|in:accepted,declined'
        ]);
        
        $userId = Auth::id();
        $response = $request->input('response');
        
        // Mettre à jour le statut de participation
        DB::table('event_participants')
            ->where('event_id', $id)
            ->where('user_id', $userId)
            ->update([
                'status' => $response,
                'updated_at' => Carbon::now()
            ]);
        
        // Envoyer une notification au créateur de l'événement
        $event = $this->getEventById($id);
        $this->sendEventNotification($id, $event->creator_id, 'response', $userId);
        
        return redirect()->route('admin.events.show', $id)->with('success', 'Réponse enregistrée avec succès');
    }
    
    /**
     * Envoyer une notification pour un événement
     */
    private function sendEventNotification($eventId, $userId, $type, $actorId = null)
    {
        $event = $this->getEventById($eventId);
        $message = '';
        
        switch ($type) {
            case 'invitation':
                $message = 'Vous avez été invité à l\'événement "' . $event->title . '"';
                break;
            case 'update':
                $message = 'L\'événement "' . $event->title . '" a été mis à jour';
                break;
            case 'response':
                $actor = $this->getUserById($actorId);
                $message = $actor->nom . ' ' . $actor->prenom . ' a répondu à l\'invitation pour l\'événement "' . $event->title . '"';
                break;
        }
        
        DB::table('notifications')->insert([
            'user_id' => $userId,
            'type' => 'event',
            'entity_id' => $eventId,
            'message' => $message,
            'read' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
    
    /**
     * Récupérer tous les événements
     */
    private function getAllEvents()
    {
        $userId = Auth::id();
        
        // Pour les besoins de démonstration, nous allons créer des données factices
        $events = [
            (object)[
                'id' => 1,
                'titre' => 'Réunion pédagogique',
                'description' => 'Discussion sur les nouveaux programmes',
                'date_debut' => Carbon::now()->addDays(2)->setHour(14)->setMinute(0),
                'date_fin' => Carbon::now()->addDays(2)->setHour(16)->setMinute(0),
                'location' => 'Salle B204',
                'type' => 'private',
                'creator_id' => 1,
                'creator_email' => 'admin@etaalim.com',
                'creator' => (object)[
                    'nom' => 'Admin',
                    'prenom' => ''
                ],
                'participants_count' => 5,
                'created_at' => Carbon::now()->subDays(5)
            ],
            (object)[
                'id' => 2,
                'titre' => 'Conférence sur l\'IA',
                'description' => 'Présentation des dernières avancées en intelligence artificielle',
                'date_debut' => Carbon::now()->addDays(7)->setHour(10)->setMinute(0),
                'date_fin' => Carbon::now()->addDays(7)->setHour(12)->setMinute(30),
                'location' => 'Amphithéâtre A',
                'type' => 'public',
                'creator_id' => 2,
                'creator_email' => 'jean.dupont@etaalim.com',
                'creator' => (object)[
                    'nom' => 'Dupont',
                    'prenom' => 'Jean'
                ],
                'participants_count' => 0,
                'created_at' => Carbon::now()->subDays(2)
            ],
            (object)[
                'id' => 3,
                'titre' => 'Atelier de programmation',
                'description' => 'Initiation à la programmation Python',
                'date_debut' => Carbon::now()->addDays(5)->setHour(9)->setMinute(30),
                'date_fin' => Carbon::now()->addDays(5)->setHour(12)->setMinute(30),
                'location' => 'Salle informatique C103',
                'type' => 'private',
                'creator_id' => 3,
                'creator_email' => 'sophie.martin@etaalim.com',
                'creator' => (object)[
                    'nom' => 'Martin',
                    'prenom' => 'Sophie'
                ],
                'participants_count' => 12,
                'created_at' => Carbon::now()->subDays(3)
            ]
        ];
        
        return $events;
    }
    
    /**
     * Récupérer un événement par son ID
     */
    private function getEventById($id)
    {
        $events = $this->getAllEvents();
        
        foreach ($events as $event) {
            if ($event->id == $id) {
                return $event;
            }
        }
        
        return null;
    }
    
    /**
     * Récupérer les participants d'un événement
     */
    private function getEventParticipants($eventId)
    {
        // Pour les besoins de démonstration, nous allons créer des données factices
        if ($eventId == 1) {
            return [
                (object)[
                    'id' => 2,
                    'nom' => 'Dupont',
                    'prenom' => 'Jean',
                    'email' => 'jean.dupont@etaalim.com',
                    'role' => 'Enseignant',
                    'status' => 'accepted'
                ],
                (object)[
                    'id' => 3,
                    'nom' => 'Martin',
                    'prenom' => 'Sophie',
                    'email' => 'sophie.martin@etaalim.com',
                    'role' => 'Enseignant',
                    'status' => 'accepted'
                ],
                (object)[
                    'id' => 4,
                    'nom' => 'Dubois',
                    'prenom' => 'Pierre',
                    'email' => 'pierre.dubois@etaalim.com',
                    'role' => 'Enseignant',
                    'status' => 'invited'
                ],
                (object)[
                    'id' => 5,
                    'nom' => 'Leroy',
                    'prenom' => 'Marie',
                    'email' => 'marie.leroy@etaalim.com',
                    'role' => 'Enseignant',
                    'status' => 'declined'
                ]
            ];
        } elseif ($eventId == 3) {
            return [
                (object)[
                    'id' => 6,
                    'nom' => 'Bernard',
                    'prenom' => 'Thomas',
                    'email' => 'thomas.bernard@etaalim.com',
                    'role' => 'Étudiant',
                    'status' => 'accepted'
                ],
                (object)[
                    'id' => 7,
                    'nom' => 'Petit',
                    'prenom' => 'Julie',
                    'email' => 'julie.petit@etaalim.com',
                    'role' => 'Étudiant',
                    'status' => 'accepted'
                ],
                // Ajouter d'autres participants...
            ];
        }
        
        return [];
    }
    
    /**
     * Récupérer tous les utilisateurs
     */
    private function getAllUsers()
    {
        // Pour les besoins de démonstration, nous allons créer des données factices
        return [
            (object)[
                'id' => 2,
                'nom' => 'Dupont',
                'prenom' => 'Jean',
                'email' => 'jean.dupont@etaalim.com',
                'role' => 'Enseignant'
            ],
            (object)[
                'id' => 3,
                'nom' => 'Martin',
                'prenom' => 'Sophie',
                'email' => 'sophie.martin@etaalim.com',
                'role' => 'Enseignant'
            ],
            (object)[
                'id' => 4,
                'nom' => 'Dubois',
                'prenom' => 'Pierre',
                'email' => 'pierre.dubois@etaalim.com',
                'role' => 'Enseignant'
            ],
            (object)[
                'id' => 5,
                'nom' => 'Leroy',
                'prenom' => 'Marie',
                'email' => 'marie.leroy@etaalim.com',
                'role' => 'Enseignant'
            ],
            (object)[
                'id' => 6,
                'nom' => 'Bernard',
                'prenom' => 'Thomas',
                'email' => 'thomas.bernard@etaalim.com',
                'role' => 'Étudiant'
            ],
            (object)[
                'id' => 7,
                'nom' => 'Petit',
                'prenom' => 'Julie',
                'email' => 'julie.petit@etaalim.com',
                'role' => 'Étudiant'
            ]
            // Ajouter d'autres utilisateurs...
        ];
    }
    
    /**
     * Récupérer un utilisateur par son ID
     */
    private function getUserById($id)
    {
        $users = $this->getAllUsers();
        
        foreach ($users as $user) {
            if ($user->id == $id) {
                return $user;
            }
        }
        
        return null;
    }
}
