<?php

namespace Credite;


class PersoaneFizice extends \Eloquent
{
    protected $table = 'persoane_fizice';
    protected $guarded = [  'client_extern',
                            'client_id',
                            'tip',
                            'an_constructie',
                            'localizare',
                            'marime',
                            'regim_juridic',
                            'valoare_estimata',
                            ];

    public static function getRecord( $id )
    {
        return self::find($id);
    }

    public static function createRecord($data )
    {
        if($data['client_extern'] == 1){
            /*trimite email*/
            $client = self::create($data);   
            self::sendEmail($client);
            return $client;
        }
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

    public static function sendEmail($client){
        /**
         * Declansez evenimentul de trimitere email
         **/
        $mailler = new \Mailers\Mailer();
        $mailler->sendTo(
            'ioana.biris@creditfin.ro',
//            'lupacescueduard@yahoo.com',
            'Clientul - ' . $client->nume . ' ' . $client->prenume, 
            'emails.client.confirmare', 
            [
                'body' => \View::make('extern.email-content')->with([
                        'client'          => $client,
                    ])->render(),
                'client'  => $client,
            ]
        );
       /* \Event::fire('client.send-confirm-email', [
            'client'          => $client,
        ]);*/

        return ['success' => true];
    } 

    public static function getPerioada(){
        return [
            '0' => '-- Alege --',
            'Determinată'   => 'Determinată',
            'Nedeterminată' => 'Nedeterminată',
            ];
    }

    public static function getTipAngajator(){
        return [
            '0' => '-- Alege --',
            '1'   => 'Instituție financiară',
            '2' => 'Corporație multinațională',
            '3' => 'Sector public',
            '4' => 'Companie de stat',
            '5' => 'Companie privată romană',
            '6' => 'Regie autonomă',
            '7' => 'Companie străină',
            '8' => 'Societate cu răspundere limitată',
            '9' => 'Societate în nume colectiv',
            '10' => 'Societate pe acțiuni',
            '11' => 'Poliție/Armată',
            '12' => 'Jandarmerie',
            '13' => 'Alte entități', 
            ];
    }

    public static function getNrAngajati(){
        return[
            '0' => '-- Alege --',
            '1' => 'Între 0 și 10',
            '2' => 'Între 11 și 20',
            '3' => 'Între 21 și 50',
            '4' => 'Între 51 și 100',
            '5' => 'Între 101 și 250',
            '6'  => 'Peste 250',
        ];
    }

    public static function getUltimStudii(){
        return[
            '0' => '-- Alege --',
            '1' => 'Gimnaziu',
            '2' => 'Liceu',
            '3' => 'Postuniversitare',
            '4' => 'Școală postliceală',
            '5' => 'Școală profesională',
            '6' => 'Superioare',
        ];
    }

    public static function getStareCivila(){
        return[
            '0' => '-- Alege --',
            '1' => 'Necăsătorit/ă',
            '2' => 'Căsătorit/ă',  
            '3' => 'Divorțat/ă',
            '4' => 'Văduv/a',     
        ];
    }

    public static function getSitLocativa(){
        return[
            '0' => '-- Alege --',
            '1' => 'Chirie',
            '2' => 'Locuiește cu părinții',
            '3' => 'Proprietar cu ipotecă',
            '4' => 'Proprietar făra ipotecă',
            '5' => 'Alțe situații',
        ];
    }

    public static function getBanca(){
        return[ 
            '-1' => '-- Alege banca --',
            '0' => 'Nu incasez banii in cont',
        ] /*+ \Credite\Banca::orderBy('nume')->lists('nume', 'id')*/

            ;
    }

    public static function getTipClient(){
        return[
            '0' => '-- Alege --',
            '1' => 'Prima casă',
            '2' => 'Credit de achiziție',
            '3' => 'Credit de nevoi personale cu ipotecă',
            '4' => 'Credit construcție',
            '5' => 'Credit de renovări/amenajări',
            '6' => 'Refinanțări',
            '7' => 'Nevoi personale',
            '8' => 'Credite medicale/studii/vacanțe',
            '9' => 'Leasing',
        ];
    }

    public static function getRelatie()
    {
        return [
            '0' => '-- Alege --',
            '1' => 'sot/sotie',
            '2' => 'mama/tata',
            '3' => 'sora/frate',
            '4' => 'fiu/fiica',
            '5' => 'partener/partenera',
            '6' => 'cumnat/cumnata',
            '7' => 'socru/soacra'
        ];
    }

    public static function tipCredit()
    {
        return [
            '0' => '-- Alege --',
          '1' => 'prima casa',    
          '2' => 'ipotecar',
            '3' => 'constructie',
            '4' => 'consum cu garantie',
            '5' => 'consum fara garantie',
            '6' => 'refinantare',
        ];
    }

    public static function valuta()
    {
        return[
            'RON' => 'RON',
            'EUR' => 'EUR',
        ];
    }

    public static function indice_referinta()
    {
        return [
            'indice_referinta_robor_3' => 'Indice de referinta Robor calculat la 3 luni',
            'indice_referinta_robor_months_6' => 'Indice de referinta Robor calculat la 6 luni',
            'indice_referinta_robor_euribor_3' => 'Indice de referinta EURIBOR calculat la 3 luni',
            'indice_referinta_robor_euribor_6' => 'Indice de referinta EURIBOR calculat la 6 luni',
        ];
    }

    public static function toCombobox()
    {
        return [0 => ' -- Selectaţi persoana --'] + self::orderBy('nume')->lists('nume', 'id');
    }   
     
}