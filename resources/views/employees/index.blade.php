@extends('dashboard')

@section('content')
<div class="card has-table">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
        Employees {{ isset($detail) ? 'of '.$employees[0]->company_name : '' }}
      </p>
    </header>
    <div class="card-content">
      <table>
        <thead>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Company</th>
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
          <td data-label="Company">
            <a href="{{ route('companies.show', $employee->company_id) }}" target="_blank">{{ $employee->company_name }}</a>
          </td>
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
              <button class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                <span class="icon"><i class="mdi mdi-pencil"></i></span>
              </button>
              <button class="button small red --jb-modal" data-target="sample-modal" type="button">
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
  </div>
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
