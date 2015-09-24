<?php namespace App\Models\Libs;

class Mesaj extends \Illuminate\Database\Eloquent\Model 
{

    protected $table = 'messages';

    public static function insertMesajeClasa($subiect, $mesaj, $elevi, $clasa_id, $from)
    {
    	self::unguard();
        foreach($elevi as $i => $id)
        {
            try
            {
            	$user = \App\Models\User::where('userable_id', $id)->where('userable_type', 'student')->get()->first();
            	if($user)
            	{
            		self::insert([
	            		'date' => \Carbon\Carbon::now()->format('Y-m-d'),
	            		
	            		'user_to'        => $user->id,
	            		'userable_to'    => $user->userable_id,
	            		'user_type_to'   => $user->userable_type,
	            		'user_name_to'   => $user->name,

	            		'user_from'      => $from->id,
	            		'userable_from'  => $from->userable_id,
	            		'user_type_from' => $from->userable_type,
	            		'user_name_from' => $from->name,

	            		'subiect' => $subiect,
	            		'mesaj'   => $mesaj,

	            		'status'  => 'new'

	            	]);
	            }
            }
            catch(\Exception $e)
            {
                // return ['success' => $student_id . '==>' . $e->getMessage() ];
            }
        }
        return ['success' => true];
    }
}