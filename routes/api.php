<?php

use App\Events\ChatCreated;
use App\Events\MessageSend;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembershipsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicationsController;
use App\Http\Controllers\ApplicantsControllerer;
use App\Http\Controllers\ChatController;
use App\Models\User;
use App\Models\ChatMessage;
use App\Models\Chats;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Log;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Obtiene la lista de las membresias creadas
Route::get('/listMemberships', [MembershipsController::class, 'listMemberships']);

 //Ruta para obtener una publicacion
 Route::get('/publication/{id_publication}', [PublicationsController::class, 'getPublication']);
 //Ruta para listar todas las publicaciones
 Route::get('/publications', [PublicationsController::class, 'listPublications']);
 //Ruta para listar las publicaciones de un usuario
 Route::get('/publications/{id_user}', [PublicationsController::class, 'listPublicationsByUser']);
 // Ruta para obtener el límite de publicaciones de un usuario basado en su plan
Route::get('/user/{id_user}/publication-limit', [PublicationsController::class, 'getPublicationLimit']);



 //Estas rutas requieren autenticacion mediante un token
Route::middleware('auth:sanctum')->group(function () {
    //Ruta para obtener el usuario con el token
    Route::get('/me', [AuthController::class, 'getUser']);
    //Ruta para listar los usuarios registrados
    Route::get('/users', [AuthController::class, 'listUsers']);
    //Ruta de cerrar sesion
    Route::post('/logout', [AuthController::class, 'logout']);
    //Ruta para obtener un usuario por su id
    Route::get('/user/{id_user}', [AuthController::class, 'getUserById']);


    //Ruta para crear un perfil
    Route::post('/profile', [ProfileController::class, 'createProfile']);
    //Ruta para obtener un perfil
    Route::get('/profile/{id_user}', [ProfileController::class, 'getProfile']);
    //Ruta para actualizar un perfil
    Route::put('/profile/{id_user}', [ProfileController::class, 'updateProfile']);
    //Ruta para obtener el perfil de un usuario
    Route::get('/profile/user/{user_name}', [ProfileController::class, 'getProfileByUserName']);


    //Ruta para crear una membresia
    Route::post('/membership', [MembershipsController::class, 'createMembership']);
    //Ruta para obtener una membresia
    Route::get('/membership/{id_membership}', [MembershipsController::class, 'getMembership']);
    //Ruta para actualizar una membresia
    Route::put('/membership/{id_membership}', [MembershipsController::class, 'updateMembership']);
    //Ruta para eliminar una membresia
    Route::delete('/membership/{id_membership}', [MembershipsController::class, 'deleteMembership']);

    //Ruta para crear una publicacion
    Route::post('/publication', [PublicationsController::class, 'createPublication']);
    //Ruta para actualizar una publicacion
    Route::put('/publication/{id_publication}', [PublicationsController::class, 'updatePublication']);
    //Ruta para eliminar una publicacion
    Route::delete('/publication/{id_publication}', [PublicationsController::class, 'deletePublication']);

    //Ruta para crear un solicitante
    Route::post('/applicant', [ApplicantsControllerer::class, 'createApplicant']);
    //Ruta para obtener un solicitante
    Route::get('/applicant/{id_applicant}', [ApplicantsControllerer::class, 'getApplicant']);
    //Ruta para obtener los solicitantes de una publicacion
    Route::get('/applicants/publication/{id_publication}', [ApplicantsControllerer::class, 'getApplicantsByPublication']);
    //Ruta para obtener los solicitantes de un usuario
    Route::get('/applicants/user/{id_user}', [ApplicantsControllerer::class, 'getApplicantsByUser']);
    //Ruta para eliminar un solicitante
    Route::delete('/applicant/{id_applicant}', [ApplicantsControllerer::class, 'deleteApplicant']);
    //Ruta para eliminar al solicitante por id de usuario y publicacion
    Route::delete('/applicants/user/{id_user}/publication/{id_publication}', [ApplicantsControllerer::class, 'deleteApplicantByUserPublication']);
    //Ruta para cambiar el estado de un solicitante
    Route::put('/applicant', [ApplicantsControllerer::class, 'changeApplicantStatus']);
    //Ruta para obtener los solicitantes de una publicacion por su estado
    Route::get('/applicant/{id_publicacion}/accepted', [ApplicantsControllerer::class, 'getApplicantsByPublicationStatus']);


    //Ruta para crear un chat
    Route::post('/chat', [ChatController::class, 'createChat']);
    //Ruta para obtener todos los chats del usuario logueado
    Route::get('/chat', [ChatController::class, 'getChats']);


    Route::get('/messages', function (Request $request) {
        $loggedInUserId = $request->user()->id;
    
        $messages = Chats::query()
            ->where(function ($query) use ($loggedInUserId) {
                $query->where('user_one_id', $loggedInUserId)
                    ->orWhere('user_two_id', $loggedInUserId);
            })
            ->with([
                'userOne:id,user_name', 
                'userTwo:id,user_name', 
                'userOne.profile:id_user,image_url', 
                'userTwo.profile:id_user,image_url',
                'publication:id,title',
                'messages' => function ($query) {
                    $query->orderBy('created_at', 'asc'); 
                },
                'publication.applicants' => function ($query) use ($loggedInUserId) {
                    $query->where('id_user', '!=', $loggedInUserId) // Excluir al usuario logueado
                          ->select('id_publication', 'id_user', 'is_selected'); // Traer solo los campos necesarios
                },
            ])
            ->get();
    
        // Filtrar los resultados para incluir solo los datos necesarios
        $messages->each(function ($chat) use ($loggedInUserId) {
            if ($chat->user_two_id !== $loggedInUserId && $chat->publication) {
                // Agregar el campo is_selected dinámicamente
                $chat->setAttribute('is_selected', $chat->publication->applicants->first()->is_selected ?? null);
            } else {
                $chat->setAttribute('is_selected', null);
            }
            unset($chat->publication->applicants); // Eliminar la relación applicants para no sobrecargar la respuesta
        });
    
        Log::info('Mensajes obtenidos:', ['messages' => $messages]);
        return $messages;
    });

    Route::get('/messages', function (Request $request) {
        $loggedInUserId = $request->user()->id;
    
        $messages = Chats::query()
            ->where(function ($query) use ($loggedInUserId) {
                $query->where('user_one_id', $loggedInUserId)
                    ->orWhere('user_two_id', $loggedInUserId);
            })
            ->with([
                'userOne:id,user_name', 
                'userTwo:id,user_name', 
                'userOne.profile:id_user,image_url', 
                'userTwo.profile:id_user,image_url',
                'publication:id,title',
                'messages' => function ($query) {
                    $query->orderBy('created_at', 'asc'); 
                },
                'publication.applicants' => function ($query) use ($loggedInUserId) {
                    $query->where('id_user', '!=', $loggedInUserId) // Excluir al usuario logueado
                          ->select('id_publication', 'id_user', 'is_selected'); // Traer solo los campos necesarios
                },
            ])
            ->get();
    
        // Filtrar los resultados para incluir solo los datos necesarios
        Log::info('Mensajes obtenidos:', ['messages' => $messages]);
        $messages->each(function ($chat) use ($loggedInUserId) {
            // Verificar si la publicación está cargada y tiene aplicaciones
            if ($chat->user_two_id !== $loggedInUserId && $chat->relationLoaded('publication') && $chat->publication) {
                $applicant = $chat->publication->applicants->firstWhere('id_user', $chat->user_two_id);
                $chat->setAttribute('is_selected', $applicant->is_selected ?? null);
            } else {
                $chat->setAttribute('is_selected', null);
            }
    
            // Eliminar la relación applicants para no sobrecargar la respuesta
            if ($chat->relationLoaded('publication') && $chat->publication) {
                unset($chat->publication->applicants);
            }
        });
    
        return $messages;
    });
    //Cambiar estado del mensaje
    Route::put('/messages', function(Request $request) {
        try{
            $request->validate([
                'id_chat' => 'required|integer', // ID del chat
            ]);
        
            // Obtener el usuario logueado
            $loggedInUserId = $request->user()->id;
        
            // Actualizar los mensajes que cumplan con las condiciones
            $updatedMessages = ChatMessage::where('id_chat', $request->id_chat)
                ->where('id_user', '!=', $loggedInUserId)
                ->where('message_status', false) 
                ->update(['message_status' => true]); 
        
            
            return response()->json([], 200);
        } catch(\Exception $e){
            return response()->json(['error' => 'Error al cambiar el estado del mensaje: ' . $e->getMessage()], 500);
        }
        
    });
    Route::get('/chats/{id}', function ($id) {
        $chat = \App\Models\Chats::with([
            'userOne:id,user_name', 
            'userTwo:id,user_name', 
            'userOne.profile:id_user,image_url', 
            'userTwo.profile:id_user,image_url',
            'publication:id,title',
            'messages' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
        ])->find($id);

        if (!$chat) {
            return response()->json(['error' => 'Chat no encontrado'], 404);
        }

        return $chat;
    });

    Route::post('/membershipsUpdate', [AuthController::class, 'updateMembership']);

    //************************** Rutas para los seguidores ************************************
    //Ruta para seguir usuario
    Route::post('/follow/{id}', [FollowController::class, 'follow'])->name('follow');
    //Ruta para dejar de seguir
    Route::post('/unfollow/{id}', [FollowController::class, 'unfollow'])->name('unfollow');
    //Ruta para obtener mis seguidores
    Route::get('/followers', [FollowController::class, 'myFollowers'])->name('followers');
    //Ruta para obtener a qienes sigo
    Route::get('/following', [FollowController::class, 'myFollowing'])->name('following');
});

