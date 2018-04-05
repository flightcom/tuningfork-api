<?php

namespace Managers\Loans;

use App\Notifications\LoanCreated;
use Models\Instrument;
use Models\Loan;
use Models\Location;
use Models\User;

class LoansManager
{
    /*
    |--------------------------------------------------------------------------
    | LoansManager
    |--------------------------------------------------------------------------
    |
    | The LoansManager is simply the business logic between the controller and
    | the model.
    |
    */

    /**
     * @return mixed
     */
    public function query()
    {
        return Loan::paginate();
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public function store(array $data)
    {
        $loanStatus = config('constants.default_loan_status');

        if (isset($data['status'])) {
            if (!array_key_exists($data['status'], config('constants.loan_status'))) {
                return null;
            }

            $loanStatus = config('constants.loan_status')[$data['status']];
        }

        $loan = Loan::create([
            // 'first_name' => $data['first_name'],
            // 'last_name' => $data['last_name'],
            // 'email' => $data['email'],
            // 'phone' => $data['phone'] ?? null,
            // 'birth_date' => $data['birth_date'] ? date('Y-m-d', strtotime($data['birth_date'])) : date('Y-m-d'),
            // 'password' => $data['password'],
            // 'status' => $userStatus,
        ]);

        // // If an avatar was added, save it
        // if (array_key_exists('avatar', $data)) {
        //     $this->saveAvatar($user, $data['avatar']);
        // }

        // // If location, save it
        // if (array_key_exists('location', $data)) {
        //     $location = Location::create($data['location']);
        //     $user->location()->save($location);
        // }

        $user->notify(new LoanCreated($loan));

        return $user;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        return User::find($id)->load('location', 'roles');
    }

    /**
     * @param array $data
     * @param $id
     *
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return $loan;
        }

        $loan->fill($data);

        // // If an avatar was added, save it
        // if (array_key_exists('avatar', $data)) {
        //     $this->saveAvatar($loan, $data['avatar']);
        // }

        // // If location, save it
        // if (array_key_exists('location', $data)) {
        //     $loan->location->fill($data['location']);
        //     $loan->location->save();
        // }

        return $loan->save();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return Loan::destroy($id);
    }

    /**
     * This function returns required information to display on the users
     * view.
     *
     * @param int    $perPage
     * @param string $search
     * @param string $status
     *
     * @return array
     */
    public function search($perPage = 15, $filter = null, $sort = null)
    {
        $loans = Loan::query();

        if ($filter) {
            foreach ($filter as $key => $value) {
                $loans->where($key, 'LIKE', "%$value%");
            }
        }

        if ($sort) {
            list($field, $direction) = $sort;
            $loans->orderBy($field, $direction);
        }

        return $loans->paginate($perPage);
    }
}
