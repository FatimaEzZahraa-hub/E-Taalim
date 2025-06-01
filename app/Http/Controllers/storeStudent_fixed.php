/**
 * Enregistre un nouvel u00e9tudiant
 */
public function storeStudent(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nom' => 'required|string|max:100',
        'prenom' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'niveau_id' => 'required|exists:niveaux,id',
        'groupe_id' => 'nullable|exists:groupes,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        // Cru00e9er un nouvel utilisateur dans la table users
        $userId = DB::table('users')->insertGetId([
            'name' => $request->nom . ' ' . $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'niveau_id' => $request->niveau_id,
            'groupe_id' => $request->groupe_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Si un groupe est spu00e9cifiu00e9, ajouter l'u00e9tudiant au groupe
        if ($request->groupe_id) {
            DB::table('groupe_student')->insert([
                'groupe_id' => $request->groupe_id,
                'user_id' => $userId,
                'date_affectation' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'u00c9tudiant ajoutu00e9 avec succu00e8s');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Erreur lors de l\'ajout de l\'u00e9tudiant: ' . $e->getMessage()])->withInput();
    }
}
