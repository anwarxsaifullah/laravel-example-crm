@extends('dashboard')

@section('content')

<section class="section main-section">
@if($errors->any())
  @foreach($errors->all() as $error)
    @include('notification-red')
  @endforeach
@endif

@if ($request->session()->has('status'))
  @include('notification-green')
@endif

<div class="card has-table" id="employees">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
        Employees {{ isset($detail) ? 'of '.$company_name : '' }}
      </p>
    </header>
    <div class="p-6">
      <form action="@if(!isset($company_name)) {{ route('employees.index') }} @endif" class="mb-3">
        {{-- @csrf --}}
        <div class="field">
          <label class="label" for="search">Search an employee</label>
          <div class="control">
            <input type="text" name="search" class="input" required id="search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}" placeholder="Enter a name, company, email, or phone...">
          </div>
          {{-- <p class="help">Type a company</p> --}}
        </div>
        <div class="field">
          <div class="control">
            <button type="submit" class="button blue mr-2">
              Search
            </button>
            <button class="add button green --jb-modal" data-target="add-modal" data-action="{{ route('companies.store') }}">+ Add</button>
          </div>
        </div>
      </form>
    </div>
    <hr>
    @if(isset($employees[0]))
    <div class="card-content">
      <table>
        <thead>
        <tr>
          <th></th>
          <th>Name</th>
          @if(!isset($detail))
          <th>Company</th>
          @endif
          <th>Email</th>
          <th>Phone</th>
          {{-- <th>Created</th> --}}
          <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($employees as $employee)
        <tr>
          <td></td>
          <td data-label="Name">{{ $employee->first_name .' '. $employee->last_name }} </td>
          @if(!isset($detail))
          <td data-label="Company">
            <a href="{{ route('companies.show', $employee->company_id) }}" target="_blank">{{ $employee->company_name }}</a>
          </td>
          @endif
          <td data-label="Email">{{ $employee->email }} </td>
          <td data-label="Phone">{{ $employee->phone }} </td>
          {{-- <td>South Cory</td> --}}
          {{-- <td class="progress-cell">
            <progress max="100" value="79">79</progress>
          </td> --}}
          {{-- <td>
            <small class="text-gray-500" title="Oct 25, 2021">Oct 25, 2021</small>
          </td> --}}
          <td class="actions-cell">
            <div class="buttons right nowrap">
              <button class="edit button small blue --jb-modal"  data-target="edit-modal" type="button" 
                data-id="{{ $employee->id }}" 
                data-firstname="{{ $employee->first_name }}" 
                data-lastname="{{ $employee->last_name }}" 
                data-companyid="{{ $employee->company_id }}" 
                data-email="{{ $employee->email }}" 
                data-phone="{{ $employee->phone }}" 
                >
                <span class="icon"><i class="mdi mdi-pencil"></i></span>
              </button>
              <button class="delete button small red --jb-modal" data-target="delete-modal" type="button" data-item="{{ $employee->first_name . $employee->last_name }}" data-id="{{ $employee->id }}">
                <span class="icon"><i class="mdi mdi-trash-can"></i></span>
              </button>
            </div>
          </td>
        </tr>
        @endforeach
        
        </tbody>
      </table>
      <div class="table-pagination">
        <div class="flex items-center justify-between">
          {{ $employees->links('pages') }}
        </div>
      </div>
    </div>
    <div id="delete-modal" class="modal">
      <div class="modal-background --jb-modal-close"></div>
      <div class="modal-card max-w-xs">
        {{-- <header class="modal-card-head">
          <p class="modal-card-title">Confirmation</p>
        </header> --}}
        <section class="modal-card-body rounded-t text-center">
          <p></p>
        </section>
        <footer class="modal-card-foot justify-center">
          <button class="button --jb-modal-close">Cancel</button>
          <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="button blue" type="submit">Confirm</button>
          </form>
        </footer>
      </div>
    </div>
    @else
    <div class="card empty">
      <div class="card-content">
        <div>
          <span class="icon large"><i class="mdi mdi-emoticon-sad mdi-48px"></i></span>
        </div>
        <p>Nothing's here…</p>
      </div>
    </div>
    @endif
    <div id="edit-modal" class="modal">
      <div class="modal-background --jb-modal-close"></div>
      
      {{-- <div class="modal-card"> --}}
        <form method="post" action="{{ route('employees.update', 1) }}" enctype="multipart/form-data" class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Edit</p>
          </header>
          
          <section class="modal-card-body">
            {{-- <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
            <p>This is sample modal</p> --}}
            <div class="card-content">
              
                @csrf
                @method('patch')
                <div class="field">
                  {{-- <label class="label">From</label> --}}
                  <div class="field-body">
                    
                    <div class="field">
                      <label for="first_name" class="label">First Name</label>
                      <div class="control icons-left">
                        <input class="input" type="text" placeholder="First name" id="first_name" name="first_name" required>
                        <span class="icon left"><i class="mdi mdi-account"></i></span>
                      </div>
                    </div>
                    <div class="field">
                      <label for="last_name" class="label">Last Name</label>
                      <div class="control icons-left">
                        <input class="input" type="text" placeholder="Last name" id="last_name" name="last_name" required>
                        <span class="icon left"><i class="mdi mdi-account"></i></span>
                      </div>
                    </div>
                    <div class="field">
                      <label for="company_id" class="label">Company</label>
                      <div class="control icons-left icons-right">
                        {{-- <div class="control"> --}}
                          <div class="select">
                            <select required name="company_id" id="company_id">
                              <option value="">Select a company</option>
                              @foreach ($companies as $company)
                              {{-- <option value="{{ $company->id }}" {{ ($company->name === $company_name) ? 'selected' : '' }}>{{$company->name}}</option> --}}
                              <option value="{{ $company->id }}" @if(isset($company_name)) @if($company->name === $company_name) selected @endif @endif>{{$company->name}}</option>
                              @endforeach
                            </select>
                          </div>
                        {{-- </div> --}}
                        {{-- <input class="input" type="text" placeholder="Company" value="" id="company" name="company" required> --}}
                        <span class="icon left"><i class="mdi mdi-city"></i></span>
                        {{-- <span class="icon right"><i class="mdi mdi-check"></i></span> --}}
                      </div>
                    </div>
                    <div class="field">
                      <label for="email" class="label">Email</label>
                      <div class="control icons-left icons-right">
                        <input class="input" type="email" placeholder="Email" value="" id="email" name="email" required>
                        <span class="icon left"><i class="mdi mdi-mail"></i></span>
                        {{-- <span class="icon right"><i class="mdi mdi-check"></i></span> --}}
                      </div>
                    </div>
                    <div class="field">
                      <label for="phone" class="label">Phone</label>
                      <div class="control icons-left icons-right">
                        <input class="input" type="tel" placeholder="Phone" value="" id="phone" name="phone" required>
                        <span class="icon left"><i class="mdi mdi-phone"></i></span>
                        {{-- <span class="icon right"><i class="mdi mdi-check"></i></span> --}}
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </section>
  
          <footer class="modal-card-foot">
            <div class="button --jb-modal-close">Cancel</div>
            <button class="button green" type="submit">Submit</button>
          </footer>
        </form>
      {{-- </div> --}}
    </div>
    <div id="add-modal" class="modal">
      <div class="modal-background --jb-modal-close"></div>
      
      {{-- <div class="modal-card"> --}}
        <form method="post" action="{{ route('employees.store') }}" enctype="multipart/form-data" class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Add</p>
          </header>
          
          <section class="modal-card-body">
            {{-- <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
            <p>This is sample modal</p> --}}
            <div class="card-content">
              
                @csrf
                <div class="field">
                  {{-- <label class="label">From</label> --}}
                  <div class="field-body">
                    
                    <div class="field">
                      <label for="first_name" class="label">First Name</label>
                      <div class="control icons-left">
                        <input class="input" type="text" placeholder="First name" id="first_name" name="first_name" required>
                        <span class="icon left"><i class="mdi mdi-account"></i></span>
                      </div>
                    </div>
                    <div class="field">
                      <label for="last_name" class="label">Last Name</label>
                      <div class="control icons-left">
                        <input class="input" type="text" placeholder="Last name" id="last_name" name="last_name" required>
                        <span class="icon left"><i class="mdi mdi-account"></i></span>
                      </div>
                    </div>
                    <div class="field">
                      <label for="company" class="label">Company</label>
                      <div class="control icons-left icons-right">
                        {{-- <div class="control"> --}}
                          <div class="select">
                            <select required name="company_id">
                              <option value="">Select a company</option>
                              @foreach ($companies as $company)
                              {{-- <option value="{{ $company->id }}" {{ ($company->name === $company_name) ? 'selected' : '' }}>{{$company->name}}</option> --}}
                              <option value="{{ $company->id }}" @if(isset($company_name)) @if($company->name === $company_name) selected @endif @endif>{{$company->name}}</option>
                              @endforeach
                            </select>
                          </div>
                        {{-- </div> --}}
                        {{-- <input class="input" type="text" placeholder="Company" value="" id="company" name="company" required> --}}
                        <span class="icon left"><i class="mdi mdi-city"></i></span>
                        {{-- <span class="icon right"><i class="mdi mdi-check"></i></span> --}}
                      </div>
                    </div>
                    <div class="field">
                      <label for="email" class="label">Email</label>
                      <div class="control icons-left icons-right">
                        <input class="input" type="email" placeholder="Email" value="" id="email" name="email" required>
                        <span class="icon left"><i class="mdi mdi-mail"></i></span>
                        {{-- <span class="icon right"><i class="mdi mdi-check"></i></span> --}}
                      </div>
                    </div>
                    <div class="field">
                      <label for="phone" class="label">Phone</label>
                      <div class="control icons-left icons-right">
                        <input class="input" type="tel" placeholder="Phone" value="" id="phone" name="phone" required>
                        <span class="icon left"><i class="mdi mdi-phone"></i></span>
                        {{-- <span class="icon right"><i class="mdi mdi-check"></i></span> --}}
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </section>
  
          <footer class="modal-card-foot">
            <button class="button --jb-modal-close">Cancel</button>
            <button class="button green" type="submit">Submit</button>
          </footer>
        </form>
      {{-- </div> --}}
    </div>
  </div>
</section>
@endsection


{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employees') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <a class="bg-green-500 mb-4 rounded p-2 hover:bg-green-600 inline-block text-white" href="{{ route('employees.create') }}">Add employee</a>
                    <table class="w-full my-4">
                        <tr>
                            <th class="border-2 p-4">Name</th>
                            <th class="border-2 p-4">Company</th>
                            <th class="border-2 p-4">Email</th>
                            <th class="border-2 p-4">Phone</th>
                            <th class="border-2 p-4"></th>
                        </tr>
                        @foreach ($employees as $employee)
                        <tr>
                            <td class="border p-4">{{ $employee->first_name .' '. $employee->last_name }}</td>
                            <td class="border p-4">{{ $employee->company }}</td>
                            <td class="border p-4">
                                <a href="mailto:{{ $employee->email }}" class="hover:text-gray-400">{{ $employee->email }}</a>
                            </td>
                            <td class="border p-4">{{ $employee->phone }}</td>
                            <td class="border p-4 w-14">
                                <a class="text-white bg-indigo-600 py-2 px-3 border rounded-lg hover:bg-indigo-700 inline-block m-2" href="{{ route('employees.edit', $employee->id) }}">
                                    Edit
                                </a>
                                <form action="{{ route('employees.destroy',$employee->id) }}" method="POST" class="inline-block">
                                    @method('DELETE')
                                    @csrf
                                    <button class="text-white bg-red-600 py-2 px-3 border rounded-lg hover:bg-red-700 inline-block" onclick="return confirm('Are you sure?')" type="submit">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $employees->links() }}
                
            </div>
        </div>
    </div>
</x-app-layout> --}}
