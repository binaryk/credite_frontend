<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tara extends \Eloquent
{
    protected $table = 'tari';
    protected $fillable = ['denumire', 'created_by', 'updated_by', 'deleted_by', 'is_deleted'];

    public static function getRecord( $id )
    {
        $record = self::find($id);
        return $record;
    }

    public static function createRecord($data )
    {
        return self::create($data);
    }

    public static function updateRecord($id, $data)
    {
        $record = self::getRecord($id);
        if( ! $record )
        {
            return false;
        }
        return $record->update($data);
    }

    public static function deleteRecord($id, $data)
    {
        $record = self::getRecord($id);
        if( ! $record )
        {
            return false;
        }
        return $record->delete();
    }
    
    public static function toCombobox()
    {
        return self::orderBy('denumire')->lists('denumire', 'id');
    }
} 