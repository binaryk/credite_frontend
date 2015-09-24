<?php namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use App\Models\Institution;
use Input;
use Validator;

class ImportController extends Base\BaseController  {

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function index() {

        return view('dashboard.import', [
            'institution' => Institution::current()
        ]);
    }

    protected function getGroup($n, $c) {

        $nums = [
            'I'    => 1,
            'II'   => 2,
            'III'  => 3,
            'IV'   => 4,
            'V'    => 5,
            'VI'   => 6,
            'VII'  => 7,
            'VIII' => 8,
            'IX'   => 9,
            'X'    => 10,
            'XI'   => 11,
            'XII'  => 12,
        ];

        if (!is_numeric($n)) {
            $n = preg_replace('/[^IVX]/', '', strtoupper($n));
            $n = isset($nums[$n]) ? $nums[$n] : 1;
        } elseif (!in_array($n, range(1, 12))) {
            $n = 1;
        }

        $c = strtoupper($c);
        $i = Institution::current();
        $s = $i->semester;

        $group = Group::firstOrCreate([
            'institution_id' => Institution::current()->id,
            'num'            => $n,
            'letter'         => $c,
            'year_id'        => $s->year_id,
        ]);

        if (empty($group->name)) {
            $group->selfRename();
            $group->save();
        }

        return $group;
    }

    protected function validateFile($file) {

        $validator = Validator::make([
            'file'      => $file,
            'extension' => $file ? strtolower($file->getClientOriginalExtension()) : '',
        ], [
            'file'      => 'required',
            'extension' => 'in:csv',
        ], [
            'file.required' => 'Nu ați selectat un fișier',
            'extension.in'  => 'Fișierul selectat nu este valid. Vă rugăm să selectați un fișier .csv',
        ]);

        if ($validator->fails()) {
            $this->throwValidationException($this->request, $validator);
        }
    }

    protected function parseCNP($cnp) {

        if (!preg_match('/^[0-9]{13}$/', $cnp)) {
            throw new \Exception('Invalid CNP');
        }

        $d = substr($cnp, 5, 2);
        $m = substr($cnp, 3, 2);
        $y = '19' . substr($cnp, 1, 2);

        if ($y < (date('Y') - 100)) {
            $y += 100;
        }

        $dob      = date('Y-m-d', strtotime("$m/$d/$y"));
        $password = substr($cnp, -8);

        $genders = ['male', 'female'];
        $gender  = $genders[1 - $cnp[0] % 2];

        return [$dob, $password, $gender];
    }

    protected function students(&$csv, &$total, &$good, &$errors, &$messages) {

        while (($line = fgetcsv($csv))) {

            ++$total;

            if (count($line) != 8) {
                $email              = isset($line[0]) ? trim($line[0]) . ' ' : '';
                $errors['format'][] = $email . '(linia ' . $total . ')';
                continue;
            }

            $email            = trim($line[0]);
            $firstname        = trim($line[1]);
            $lastname         = trim($line[2]);
            $parents_initials = trim($line[3]);
            $cnp              = trim($line[4]);
            $emergency_phone  = trim($line[5]);

            $groupno = trim($line[6]);
            $groupch = trim($line[7]);

            if (User::where('email', $email)->count()) {
                $errors['email'][] = $email . '(linia ' . $total . ')';
                continue;
            }

            try {
                list($dob, $password, $gender) = $this->parseCNP($cnp);
            } catch (\Exception $e) {
                $error           = $cnp . '(linia ' . $total . ')';
                $errors['cnp'][] = $error;
                continue;
            }

            $student = new Student([
                'firstname'        => $firstname,
                'lastname'         => $lastname,
                'gender'           => $gender,
                'dob'              => $dob,
                'cnp'              => $cnp,
                'parents_initials' => $parents_initials,
                'emergency_phone'  => $emergency_phone,
                'group_id'         => $this->getGroup($groupno, $groupch)->id,
            ]);

            $student->save();

            $user = new User([
                'name'     => implode(' ', [$firstname, $lastname]),
                'email'    => $email,
                'password' => hash::make($password),
            ]);

            $user->userable_type = 'student';
            $user->userable_id   = $student->id;
            $user->save();

            Institution::current()->users()->save($user);

            ++$good;
        }

        $messages = [
            'total' => $total,
            'good'  => $good,
        ];

        $emsg = [
            'format' => 'Următoarele linii au un format incorect:',
            'cnp'    => 'Următoarele linii au un CNP invalid:',
            'email'  => 'Următorele email-uri există deja în baza de date:',
        ];

        if (!empty($errors)) {
            foreach (array_keys($emsg) as $errtype) {
                if (!empty($errors[$errtype])) {
                    $messages[$errtype]['message'] = $emsg[$errtype];
                    $messages[$errtype]['data']    = $errors[$errtype];
                }
            }
        }

        return redirect()
            ->route('import')
            ->with('messages', $messages);
    }

    protected function teachers(&$csv, &$total, &$good, &$errors, &$messages) {

        while (($line = fgetcsv($csv))) {

            ++$total;

            if (count($line) < 4) {
                $email              = isset($line[0]) ? trim($line[0]) . ' ' : '';
                $errors['format'][] = $email . '(linia ' . $total . ')';
                continue;
            }

            $email     = trim($line[0]);
            $firstname = trim($line[1]);
            $lastname  = trim($line[2]);
            $cnp       = trim($line[3]);

            if (User::where('email', $email)->count()) {
                $errors['email'][] = $email . '(linia ' . $total . ')';
                continue;
            }

            try {
                list($dob, $password, $gender) = $this->parseCNP($cnp);
            } catch (\Exception $e) {
                $error           = $cnp . '(linia ' . $total . ')';
                $errors['cnp'][] = $error;
                continue;
            }

            $teacher = new Teacher([
                'firstname' => $firstname,
                'lastname'  => $lastname,
                'gender'    => $gender,
                'dob'       => $dob,
                'cnp'       => $cnp,
            ]);

            $teacher->save();

            $user = new User([
                'name'     => implode(' ', [$firstname, $lastname]),
                'email'    => $email,
                'password' => hash::make($password),
            ]);

            $user->userable_type = 'teacher';
            $user->userable_id   = $teacher->id;
            $user->save();

            Institution::current()->users()->save($user);

            ++$good;
        }

        $messages = [
            'total' => $total,
            'good'  => $good,
        ];

        $emsg = [
            'format' => 'Următoarele linii au un format incorect:',
            'cnp'    => 'Următoarele linii au un CNP invalid:',
            'email'  => 'Următorele email-uri există deja în baza de date:',
        ];

        if (!empty($errors)) {
            foreach (array_keys($emsg) as $errtype) {
                if (!empty($errors[$errtype])) {
                    $messages[$errtype]['message'] = $emsg[$errtype];
                    $messages[$errtype]['data']    = $errors[$errtype];
                }
            }
        }

        return redirect()
            ->route('import')
            ->with('messages', $messages);
    }

    public function import() {

        $file = $this->request->file('csv');
        $this->validateFile($file);

        $csv = fopen($file->getPathname(), 'r');

        $total    = $good = 0;
        $errors   = [];
        $messages = [];

        switch (Input::get('action')) {
            case 'students':
                $this->students($csv, $total, $good, $errors, $messages);
                break;
            case 'teachers':
                $this->teachers($csv, $total, $good, $errors, $messages);
                break;
        }

        return redirect()
            ->route('import')
            ->with('messages', $messages);
    }

}
