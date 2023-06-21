<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Silber\Bouncer\Database\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\User\StoreUserRequest;
use Silber\Bouncer\BouncerFacade as Bouncer;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);



        return view('control-panel.users.index', [
            'users' => QueryBuilder::for(User::class)
                ->with('roles')

                ->allowedFilters([
                    AllowedFilter::partial('name'),
                    AllowedFilter::exact('role', 'roles.name')
                ])
                ->paginate(10),
            'roles' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('control-panel.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->assign('user'); // assign user role
        return redirect()->route('users.show', $user)->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        session()->reflash();

        return redirect()->route('users.projects.index', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $data = [
            'user' => $user,
        ];

        if (request()->user()->can('updateRole', $user)) {
            $data['roles'] =  Bouncer::role()->pluck('title', 'title');
        }

        return view('control-panel.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $input = $request->validated();

        if (isset($input['role_title'])) {
            $role = Bouncer::role()->firstWhere('title', $input['role_title']);
            Bouncer::sync($user)->roles([$role]);
            unset($input['role_title']);
        }

        if (!$request->filled('password')) {
            unset($input['password']);
        } else {
            $input['password'] = Hash::make($input['password']);
        }

        $user->update($input);

        session()->flash('success', 'User updated successfully');

        return redirect()->route('users.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted succefully');
    }

    public function insertDataFromExcel(Request $request)
    {
        $data = [];
        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,csv'
            ]);
        } catch (ValidationException $msg){
            $data['success'] = 0;
            $data['error'] = $msg->validator->errors();
            return response()->json($data);
        }

        if ($request->file('file')){
            $data['success'] = 1;
            $users = (new FastExcel)->import($request->file('file'), function ($line) {
                return User::create([
                    'name' => $line['Name'],
                    'email' => $line['Email'],
                    'phone' => $line['Phone number'],
                    'address' => $line['Address'],
                    'password' => Hash::make('default'),
                ]);
            });

            foreach($users as $user)
            {
                $user->assign('user');
            }
        }

        return response()->json($data);
    }
}
