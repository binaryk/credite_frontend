<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localitate extends \Eloquent
{
    protected $table = 'localitati';
    protected $fillable = ['nume', 'id_judet'];

    public static function getRecord( $id )
    {
        return self::find($id);
    }

    public static function createRecord($data )
    {
        return self::create($data);
    }

    public static function updateRecord($id, $data)
    {
        $record = self::find($id);
        if( ! $record )
        {
            return false;
        }
        return $record->update($data);
    }

    public static function deleteRecord($id, $data)
    {
        $record = self::find($id);
        if( ! $record )
        {
            return false;
        }
        return $record->delete();
    }

    public static function toCombobox( $noneCaption = '')
    { 
        return self::orderBy('nume')->lists('nume', 'id');
    }
}