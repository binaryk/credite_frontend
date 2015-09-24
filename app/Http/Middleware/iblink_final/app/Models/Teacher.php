<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model {

    protected $fillable = [
        'position', 'studies', 'lead', 'spec', 'address', 'graduated_on',
        'degree', 'last_development_type', 'foreign_langs', 'employment_type', 'employment_act_no', 'employment_date',
        'maiden_name', 'lastname', 'firstname', 'cnp', 'dob', 'country_id', 'image', 'phone'
    ];

    public $timestamps = false;

    protected static $accountTypes = [
        'educator'      => 'Educator',
        'schoolteacher' => 'Învățător',
        'teacher'       => 'Profesor',
    ];

    protected static $positions = [
        'educator'                 => 'Educator',
        'educator_special'         => 'Educator la  școli speciale',
        'schoolteacher'            => 'Institutor',
        'schoolteacher_instructor' => 'Învățator Maistru instructor',
        'professor'                => 'Profesor',
        'professor_preschool'      => 'Profesor pentru învățământul preșcolar ',
        'professor_primary'        => 'Profesor pentru invățământul primar',
        'psychologist'             => 'Psiholog',
    ];

    protected static $studyTypes = [
        'secondary'      => 'Medii',
        'post_secondary' => 'Post liceal',
        'undergraduate'  => 'Studii universitare de licenta',
        'master'         => 'Studii universitare de masterat',
        'higher_long'    => 'Superioare - lunga durata',
        'higher_short'   => 'Superioare - scurta durata',
    ];

    protected static $degrees = [
        'debutant'     => 'Debutant',
        'complete'     => 'Definitivat',
        'incomplete'   => 'Fara definitivat',
        'doctor'       => 'Doctor in stiinte',
        'grade_1'      => 'Grad 1',
        'grade_2'      => 'Grad 2',
        'postgraduate' => 'Masterat postuniversitar',
    ];

    protected static $developments = [
        'no'                         => 'Fără perfecționare',
        'master_ed_management'       => 'Master în management educațional',
        'master_spec'                => 'Master în specialitate',
        'perf_cred_ed_management'    => 'Perfecționare cu credite în management educațional',
        'perf_cred_spec'             => 'Perfecționare cu credite în specialitate',
        'perf_no_cred_ed_management' => 'Perfecționare fără credite în management educațional',
        'perf_no_cred_spec'          => 'Perfecționare fără credite în specialitate',
    ];

    protected static $employmentTypes = [
        'Completare normă pe catedră rezervată',
        'Completare normă pe catedră vacantă',
        'Plata cu ora pe catedră rezervată',
        'Plata cu ora pe catedră vacantă',
        'Plata prin cumul pe catedră rezervată',
        'Plata prin cumul pe catedră vacantă',
        'Suplinitor concediu maternitate',
        'Suplinitor pe catedră rezervată',
        'Suplinitor pe catedră vacantă',
        'Suplinitor pensionat pe catedră rezervată',
        'Suplinitor pensionat pe catedră vacantă',
        'Tit. det. din alt județ, pe catedră rezerv',
        'Tit. det. din alt județ, pe catedră vacantă',
        'Tit. det. în alt județ pe catedră rezerv',
        'Tit. det. în alt județ pe catedră vacantă',
        'Tit. det. prin RA, in judet, pe catedra rezervata',
        'Tit. det. prin RA, venit din alt județ, pe cat.rez.',
        'Tit. det.p rin RA, venit din alt județ, pe cat.vac.',
        'Tit. det. prin RA., plecat în alt județ, pe cat.rez.',
        'Tit. det. prin RA., plecat în alt județ, pe cat.vac.',
        'Titular concediu medical',
        'Titular concediu maternitate',
        'Titular cu catedră rezervată (art 59)',
        'Titular cu reducere de activitate',
        'Titular detașat în județ pe catedră rezervată',
        'Titular detașat în județ pe catedră vacantă',
        'Titular în concediu fără plată',
        'Titular într-o unitate, dar detașat în alta',
        'Titular într-o unitate, dar detașat în alta (RA)',
        'Titular la catedră',
        'Titular, pensionar revizuibil',
    ];



    public static function positions(){
        return self::$positions;
    }

    public static function studies(){
        return self::$studyTypes;
    }

    public static function grad(){
        return self::$degrees;
    } 

    public static function development(){
        return self::$developments;
    }

    public static function getStaticMorphClass() {
        return 'teacher';
    }

    

    public function __construct(array $attributes = []) {
        $this->morphClass = self::getStaticMorphClass();
        parent::__construct($attributes);
    }

    public function user() {
        return $this->morphOne('App\Models\User', 'userable');
    }

    public function getRoleTitle() {
        return 'Profesor';
    }

    public function groups() {
        return $this->user->belongsToMany('\App\Models\Group', 'subject_teacher_group');
    }

    public static function getAccountTypes() {
        return self::$accountTypes;
    }

    public static function getAccountType($type) {

        if (isset(self::$accountTypes[$type])) {
            return self::$accountTypes[$type];
        }

        throw new \Exception('No such account type: ' . $type);
    }

    public static function getPositions() {
        return array_keys(self::$positions);
    }

    public static function getPosition($position) {

        if (isset(self::$positions[$position])) {
            return self::$positions[$position];
        }

        throw new \Exception('No such account type: ' . $position);
    }



    public static function getStudyTypes() {
        return self::$studyTypes;
    }

    public static function getStudyType($type) {

        if (isset(self::$studyTypes[$type])) {
            return self::$studyTypes[$type];
        }

        throw new \Exception('No such study type: ' . $type);
    }

    public static function getDegrees() {
        return array_keys(self::$degrees);
    }

    public static function getDegree($degree) {

        if (isset(self::$degrees[$degree])) {
            return self::$degrees[$degree];
        }

        throw new \Exception('No such degree: ' . $degree);
    }

    public static function getDevelopments() {
        return array_keys(self::$developments);
    }

    public static function getDevelopment($development) {

        if (isset(self::$developments[$development])) {
            return self::$developments[$development];
        }

        throw new \Exception('No such development type: ' . $development);
    }

    public static function getEmploymentTypes() {
        return array_keys(self::$employmentTypes);
    }

    public static function getEmploymentType($employmentType) {

        if (isset(self::$employmentTypes[$employmentType])) {
            return self::$employmentTypes[$employmentType];
        }

        throw new \Exception('No such employment type: ' . $employmentType);
    }

    public static function toCombobox()
    { 
        return self::select('id', \DB::raw( ' CONCAT(firstname, " ", lastname) as full_name' ))
            ->orderBy('full_name')
            ->lists('full_name', 'id');
    }

    public static function toComboboxUsers()
    { 
        return self::select('id', \DB::raw( ' where user ' ))
            ->orderBy('full_name')
            ->where('userable_type','teacher')
            ->lists('full_name', 'id');
    }

    public function group()
    {
        return $this->hasOne('App\Models\Group', 'master_id');
        //return $query->leftJoin('groups', 'teachers.id', '=', 'groups.master_id')->first();
    }

}
