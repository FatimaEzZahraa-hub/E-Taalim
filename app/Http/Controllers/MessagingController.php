<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessagingController extends Controller
{
    /**
     * Afficher la page principale de messagerie
     */
    public function index()
    {
        // Récupérer les conversations de l'utilisateur connecté
        $conversations = $this->getConversations();
        
        // Par défaut, pas de conversation active
        $activeConversation = null;
        $messages = [];
        
        return view('admin.messaging.index', compact('conversations', 'activeConversation', 'messages'));
    }
    
    /**
     * Afficher une conversation spécifique
     */
    public function viewConversation($id)
    {
        // Récupérer les conversations de l'utilisateur connecté
        $conversations = $this->getConversations();
        
        // Récupérer la conversation spécifique
        $conversation = $this->getConversationById($id);
        
        if (!$conversation) {
            return redirect()->route('admin.messaging.index')->with('error', 'Conversation non trouvée');
        }
        
        // Récupérer les messages de la conversation
        $messages = $this->getMessagesForConversation($id);
        
        // Marquer les messages comme lus
        $this->markMessagesAsRead($id);
        
        return view('admin.messaging.conversation', compact('conversations', 'conversation', 'messages'));
    }
    
    /**
     * Envoyer un message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|integer',
            'message' => 'required|string'
        ]);
        
        $conversationId = $request->input('conversation_id');
        $messageContent = $request->input('message');
        $userId = Auth::id();
        
        // Vérifier si la conversation existe
        $conversation = $this->getConversationById($conversationId);
        
        if (!$conversation) {
            return redirect()->back()->with('error', 'Conversation non trouvée');
        }
        
        // Enregistrer le message
        $messageId = DB::table('messages')->insertGetId([
            'conversation_id' => $conversationId,
            'sender_id' => $userId,
            'contenu' => $messageContent,
            'lu' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        // Mettre à jour la date de dernière activité de la conversation
        DB::table('conversations')->where('id', $conversationId)->update([
            'updated_at' => Carbon::now()
        ]);
        
        return redirect()->back()->with('success', 'Message envoyé');
    }
    
    /**
     * Créer une nouvelle conversation
     */
    public function createConversation(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|integer',
            'message' => 'required|string'
        ]);
        
        $recipientId = $request->input('recipient_id');
        $messageContent = $request->input('message');
        $userId = Auth::id();
        
        // Vérifier si une conversation existe déjà entre ces deux utilisateurs
        $existingConversation = DB::table('conversations')
            ->join('conversation_participants', 'conversations.id', '=', 'conversation_participants.conversation_id')
            ->where('conversations.type', 'individual')
            ->where('conversation_participants.user_id', $userId)
            ->whereExists(function ($query) use ($recipientId) {
                $query->select(DB::raw(1))
                    ->from('conversation_participants')
                    ->whereRaw('conversation_participants.conversation_id = conversations.id')
                    ->where('conversation_participants.user_id', $recipientId);
            })
            ->select('conversations.id')
            ->first();
        
        if ($existingConversation) {
            // Utiliser la conversation existante
            $conversationId = $existingConversation->id;
        } else {
            // Créer une nouvelle conversation
            $conversationId = DB::table('conversations')->insertGetId([
                'type' => 'individual',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            // Ajouter les participants
            DB::table('conversation_participants')->insert([
                ['conversation_id' => $conversationId, 'user_id' => $userId],
                ['conversation_id' => $conversationId, 'user_id' => $recipientId]
            ]);
        }
        
        // Enregistrer le message
        DB::table('messages')->insert([
            'conversation_id' => $conversationId,
            'sender_id' => $userId,
            'contenu' => $messageContent,
            'lu' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        return redirect()->route('admin.messaging.conversation', $conversationId)->with('success', 'Message envoyé');
    }
    
    /**
     * Créer un groupe de discussion
     */
    public function createGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'participants' => 'required|array',
            'participants.*' => 'integer'
        ]);
        
        $groupName = $request->input('name');
        $participants = $request->input('participants');
        $userId = Auth::id();
        
        // Ajouter l'utilisateur courant s'il n'est pas déjà dans la liste
        if (!in_array($userId, $participants)) {
            $participants[] = $userId;
        }
        
        // Créer le groupe
        $conversationId = DB::table('conversations')->insertGetId([
            'type' => 'group',
            'name' => $groupName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        // Ajouter les participants
        foreach ($participants as $participantId) {
            DB::table('conversation_participants')->insert([
                'conversation_id' => $conversationId,
                'user_id' => $participantId
            ]);
        }
        
        return redirect()->route('admin.messaging.conversation', $conversationId)->with('success', 'Groupe créé');
    }
    
    /**
     * Récupérer les conversations de l'utilisateur
     */
    private function getConversations()
    {
        $userId = Auth::id();
        
        // Pour les besoins de démonstration, nous allons créer des données factices
        $conversations = [
            (object)[
                'id' => 1,
                'type' => 'individual',
                'participant' => (object)[
                    'id' => 2,
                    'nom' => 'Dupont',
                    'prenom' => 'Jean',
                    'role' => 'Enseignant'
                ],
                'lastMessage' => (object)[
                    'contenu' => 'Bonjour, comment allez-vous ?',
                    'created_at' => Carbon::now()->subHours(2)
                ],
                'unreadCount' => 0
            ],
            (object)[
                'id' => 2,
                'type' => 'individual',
                'participant' => (object)[
                    'id' => 3,
                    'nom' => 'Martin',
                    'prenom' => 'Sophie',
                    'role' => 'Étudiant'
                ],
                'lastMessage' => (object)[
                    'contenu' => 'Pourriez-vous m\'aider avec mon devoir ?',
                    'created_at' => Carbon::now()->subHours(5)
                ],
                'unreadCount' => 2
            ],
            (object)[
                'id' => 3,
                'type' => 'group',
                'name' => 'Équipe pédagogique',
                'lastMessage' => (object)[
                    'contenu' => 'La réunion est prévue pour demain à 14h',
                    'created_at' => Carbon::now()->subDay()
                ],
                'unreadCount' => 1
            ]
        ];
        
        return $conversations;
    }
    
    /**
     * Récupérer une conversation par son ID
     */
    private function getConversationById($id)
    {
        $conversations = $this->getConversations();
        
        foreach ($conversations as $conversation) {
            if ($conversation->id == $id) {
                return $conversation;
            }
        }
        
        return null;
    }
    
    /**
     * Récupérer les messages d'une conversation
     */
    private function getMessagesForConversation($conversationId)
    {
        $userId = Auth::id();
        
        // Pour les besoins de démonstration, nous allons créer des données factices
        if ($conversationId == 1) {
            return [
                (object)[
                    'id' => 1,
                    'sender_id' => 2,
                    'sender' => (object)[
                        'nom' => 'Dupont',
                        'prenom' => 'Jean'
                    ],
                    'contenu' => 'Bonjour, comment allez-vous ?',
                    'created_at' => Carbon::now()->subHours(2)
                ],
                (object)[
                    'id' => 2,
                    'sender_id' => $userId,
                    'sender' => (object)[
                        'nom' => 'Admin',
                        'prenom' => ''
                    ],
                    'contenu' => 'Bonjour Jean, je vais bien merci. Et vous ?',
                    'created_at' => Carbon::now()->subHours(1)->subMinutes(45)
                ],
                (object)[
                    'id' => 3,
                    'sender_id' => 2,
                    'sender' => (object)[
                        'nom' => 'Dupont',
                        'prenom' => 'Jean'
                    ],
                    'contenu' => 'Très bien, merci ! Je voulais vous demander si vous aviez reçu mon cours sur la programmation Python ?',
                    'created_at' => Carbon::now()->subHours(1)->subMinutes(30)
                ],
                (object)[
                    'id' => 4,
                    'sender_id' => $userId,
                    'sender' => (object)[
                        'nom' => 'Admin',
                        'prenom' => ''
                    ],
                    'contenu' => 'Oui, je l\'ai bien reçu. Je vais l\'examiner aujourd\'hui et vous donner un retour.',
                    'created_at' => Carbon::now()->subHours(1)
                ]
            ];
        } elseif ($conversationId == 2) {
            return [
                (object)[
                    'id' => 5,
                    'sender_id' => 3,
                    'sender' => (object)[
                        'nom' => 'Martin',
                        'prenom' => 'Sophie'
                    ],
                    'contenu' => 'Bonjour, j\'ai une question concernant le devoir de mathématiques.',
                    'created_at' => Carbon::now()->subHours(6)
                ],
                (object)[
                    'id' => 6,
                    'sender_id' => $userId,
                    'sender' => (object)[
                        'nom' => 'Admin',
                        'prenom' => ''
                    ],
                    'contenu' => 'Bonjour Sophie, quelle est votre question ?',
                    'created_at' => Carbon::now()->subHours(5)->subMinutes(50)
                ],
                (object)[
                    'id' => 7,
                    'sender_id' => 3,
                    'sender' => (object)[
                        'nom' => 'Martin',
                        'prenom' => 'Sophie'
                    ],
                    'contenu' => 'Pourriez-vous m\'aider avec mon devoir ? Je n\'arrive pas à résoudre l\'exercice 3.',
                    'created_at' => Carbon::now()->subHours(5)
                ]
            ];
        } elseif ($conversationId == 3) {
            return [
                (object)[
                    'id' => 8,
                    'sender_id' => 4,
                    'sender' => (object)[
                        'nom' => 'Dubois',
                        'prenom' => 'Pierre'
                    ],
                    'contenu' => 'Bonjour à tous, nous devons planifier la réunion pédagogique.',
                    'created_at' => Carbon::now()->subDays(2)
                ],
                (object)[
                    'id' => 9,
                    'sender_id' => 2,
                    'sender' => (object)[
                        'nom' => 'Dupont',
                        'prenom' => 'Jean'
                    ],
                    'contenu' => 'Je suis disponible mardi ou jeudi après-midi.',
                    'created_at' => Carbon::now()->subDays(1)->subHours(6)
                ],
                (object)[
                    'id' => 10,
                    'sender_id' => 5,
                    'sender' => (object)[
                        'nom' => 'Leroy',
                        'prenom' => 'Marie'
                    ],
                    'contenu' => 'Jeudi me convient parfaitement.',
                    'created_at' => Carbon::now()->subDays(1)->subHours(4)
                ],
                (object)[
                    'id' => 11,
                    'sender_id' => 4,
                    'sender' => (object)[
                        'nom' => 'Dubois',
                        'prenom' => 'Pierre'
                    ],
                    'contenu' => 'La réunion est prévue pour demain à 14h dans la salle B204.',
                    'created_at' => Carbon::now()->subDay()
                ]
            ];
        }
        
        return [];
    }
    
    /**
     * Marquer les messages comme lus
     */
    private function markMessagesAsRead($conversationId)
    {
        $userId = Auth::id();
        
        // Dans une implémentation réelle, nous mettrions à jour la base de données ici
        // DB::table('messages')
        //     ->where('conversation_id', $conversationId)
        //     ->where('sender_id', '!=', $userId)
        //     ->where('lu', false)
        //     ->update(['lu' => true, 'updated_at' => Carbon::now()]);
        
        // Pour notre démonstration, nous allons simplement mettre à jour nos données factices
        $conversations = $this->getConversations();
        
        foreach ($conversations as $conversation) {
            if ($conversation->id == $conversationId) {
                $conversation->unreadCount = 0;
                break;
            }
        }
    }
}
