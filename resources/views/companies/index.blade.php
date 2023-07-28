@extends('dashboard')

@section('content')
<div class="card has-table">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><i class="mdi mdi-city"></i></span>
        Companies
      </p>
    </header>
    <div class="p-6">
      <form action="{{ route('companies.index') }}">
        {{-- @csrf --}}
        <div class="field">
          <label class="label" for="search">Search a company</label>
          <div class="control">
            <input type="text" name="search" class="input" required id="search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
          </div>
          {{-- <p class="help">Type a company</p> --}}
        </div>
        <div class="field">
          <div class="control">
            <button type="submit" class="button blue">
              Search
            </button>
            <button class="button green">+ Add</button>
          </div>
        </div>
      </form>
    </div>
    {{-- <div class="card-content">
      
    </div> --}}
    <hr>
    <div class="card-content">
      <table>
        <thead>
        <tr>
          <th class="image-cell"></th>
          <th>Name</th>
          <th>Company</th>
          <th>Email</th>
          {{-- <th>City</th>
          <th>Progress</th>
          <th>Created</th> --}}
          <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($companies as $company)
        <tr>
          <td class="image-cell">
            <div class="image">
              <img src="{{ $request->getBaseUrl().'/images/'.$company->logo }}" class="rounded-full">
            </div>
          </td>
          <td data-label="Name"><a href="{{ route('companies.show', $company->id) }}" target="_blank">{{ $company->name }}</a></td>
          <td data-label="Website">
            <a href="http://{{ $company->website }}" target="_blank">{{ $company->website }}</a>
          </td>
          <td data-label="Email">{{ $company->email }} </td>
          {{-- <td>South Cory</td> --}}
          {{-- <td class="progress-cell">
            <progress max="100" value="79">79</progress>
          </td> --}}
          {{-- <td>
            <small class="text-gray-500" title="Oct 25, 2021">Oct 25, 2021</small>
          </td> --}}
          <td class="actions-cell">
            <div class="buttons right nowrap">
              <button class="button small green --jb-modal"  data-target="sample-modal" type="button">
                <span class="icon"><i class="mdi mdi-eye"></i></span>
              </button>
              <button class="button small blue --jb-modal"  data-target="edit-modal" type="button">
                <span class="icon"><i class="mdi mdi-pencil"></i></span>
              </button>
              <button class="button small red --jb-modal" data-target="delete-modal" type="button">
                <span class="icon"><i class="mdi mdi-trash-can"></i></span>
              </button>
            </div>
          </td>
        </tr>
        <div id="edit-modal" class="modal">
          <div class="modal-background --jb-modal-close"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">Sample modal</p>
            </header>
            <section class="modal-card-body">
              <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
              <p>This is sample modal</p>
            </section>
            <footer class="modal-card-foot">
              <button class="button --jb-modal-close">Cancel</button>
              <button class="button red --jb-modal-close">Confirm</button>
            </footer>
          </div>
        </div>
        
        <div id="delete-modal" class="modal">
          <div class="modal-background --jb-modal-close"></div>
          <div class="modal-card max-w-xs">
            {{-- <header class="modal-card-head">
              <p class="modal-card-title">Confirmation</p>
            </header> --}}
            <section class="modal-card-body rounded-t text-center">
              <p>Company <b>{{$company->name}}</b> will be deleted.</p>
            </section>
            <footer class="modal-card-foot justify-center">
              <button class="button --jb-modal-close">Cancel</button>
              <form action="{{ route('companies.destroy', $company->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="button blue --jb-modal-close" type="submit">Confirm</button>
              </form>
            </footer>
          </div>
        </div>
        @endforeach
        
        </tbody>
      </table>
      {{-- @if() --}}
      <div class="table-pagination">
        <div class="flex items-center justify-between">
          {{ $companies->links('pages') }}
        </div>
      </div>
    </div>
  </div>
  
@endsection
{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <a class="bg-green-500 mb-4 rounded p-2 hover:bg-green-600 inline-block text-white" href="{{ route('companies.create') }}">Add company</a>
                    <table class="w-full my-4">
                        <tr>
                            <th class="border-2 p-4">Name</th>
                            <th class="border-2 p-4">Logo</th>
                            <th class="border-2 p-4">Website</th>
                            <th class="border-2 p-4">Email</th>
                            <th class="border-2 p-4"></th>
                        </tr>
                        @foreach ($companies as $company)
                        <tr>
                            <td class="border p-4">{{ $company->name }}</td>
                            <td class="border p-4 w-32">
                                <img src="{{ $request->getBaseUrl().'/images/'.$company->logo }}" alt="" class="max-w-xs">
                            </td>
                            <td class="border p-4">
                                <a href="http://{{ $company->website }}" target="_blank" class="hover:text-gray-400">{{ $company->website }}</a>
                            </td>
                            <td class="border p-4">
                                <a href="mailto:{{ $company->email }}" class="hover:text-gray-400">{{ $company->email }}</a>
                            </td>
                            <td class="border p-4 w-14">
                                <a class="text-white bg-indigo-600 py-2 px-3 border rounded-lg hover:bg-indigo-700 inline-block m-2" href="{{ route('companies.edit', $company->id) }}">
                                    Edit
                                </a>
                                <form action="{{ route('companies.destroy',$company->id) }}" method="POST" class="inline-block">
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
                    {{ $companies->links() }}
                
            </div>
        </div>
    </div>
</x-app-layout> --}}
