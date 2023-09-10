@extends('dashboard')

@section('content')

@if($errors->any())
@foreach($errors->all() as $error)
<div class="notification red">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
    <div>
      <span class="icon"><i class="mdi mdi-error"></i></span>
      <b>{{ $error }}</b>
    </div>
    <button type="button" class="button small textual bg-white --jb-notification-dismiss">Dismiss</button>
  </div>
</div>
@endforeach
@endif

@if ($request->session()->has('status'))
<div class="notification green p-2 md:py-3">
  <div class="flex flex-row items-center justify-between space-y-0">
    <div class="md:font-bold">
      <span class="icon"><i class="mdi mdi-check-bold"></i></span>
      {{ $request->session()->get('status') }}
      {{-- Come on fucking work motherfucker --}}
    </div>
    {{-- <div> --}}

      <span class="icon --jb-notification-dismiss hover:cursor-pointer"><i class="mdi mdi-close"></i></span>
    {{-- </div> --}}
    {{-- <button type="button" class="button small textual text-white --jb-notification-dismiss">Dismiss</button> --}}
  </div>
</div>  
@endif

<div class="card has-table" id="companies">
  <header class="card-header">
    <p class="card-header-title">
      <span class="icon"><i class="mdi mdi-city"></i></span>
      Companies
    </p>
  </header>
  <div class="p-6">
    <form action="{{ route('companies.index') }}" class="mb-3">
      {{-- @csrf --}}
      <div class="field">
        <label class="label" for="search">Search a company</label>
        <div class="control">
          <input type="text" name="search" class="input" required id="search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}" placeholder="Enter a company, website, or email...">
        </div>
        {{-- <p class="help">Type a company</p> --}}
      </div>
      <div class="field">
        <div class="control">
          <button type="submit" class="button blue mr-2">
            Search
          </button>
          <button class="add button green --jb-modal" data-target="add-modal">+ Add</button>
        </div>
      </div>
    </form>
  </div>
  {{-- <div class="card-content">
    
  </div> --}}
  <hr>
  @if($companies[0])
  <div class="card-content">
    <table>
      <thead>
        <tr>
          <th class="image-cell"></th>
          <th>Name</th>
          <th>Website</th>
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
            <div class="image flex justify-center items-center">
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
              <a class="button small green" href="{{ route('companies.show', $company->id) }}" target="_blank">
                <span class="icon"><i class="mdi mdi-eye"></i></span>
              </a>
              <button class="edit button small blue --jb-modal"  data-target="edit-modal" type="button" data-id="{{ $company->id }}" data-company="{{ $company->name }}" data-website="{{ $company->website }}" data-email="{{ $company->email }}" data-title="Edit" data-action="{{ route('companies.update', $company->id) }}">
                <span class="icon"><i class="mdi mdi-pencil"></i></span>
              </button>
              <button class="delete button small red --jb-modal" data-target="delete-modal" type="button" data-item="{{ $company->name }}" data-id="{{ $company->id }}">
                <span class="icon"><i class="mdi mdi-trash-can"></i></span>
              </button>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    
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
          <form action="{{ route('companies.destroy', $company->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="button blue" type="submit">Confirm</button>
          </form>
        </footer>
      </div>
    </div>
    {{-- @if() --}}
    <div class="table-pagination">
      <div class="flex items-center justify-between">
        {{ $companies->links('pages') }}
      </div>
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
      <form method="post" action="{{ route('companies.update', 1) }}" enctype="multipart/form-data" class="modal-card">
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
                    <label for="company" class="label">Company Name</label>
                    <div class="control icons-left">
                      <input class="input" type="text" placeholder="Company Name" id="company" name="name" required>
                      <span class="icon left"><i class="mdi mdi-account"></i></span>
                    </div>
                  </div>
                  <div class="field">
                    <label for="website" class="label">Website</label>
                    <div class="control icons-left icons-right">
                      <input class="input" type="text" placeholder="Website" value="" id="website" name="website" required>
                      <span class="icon left"><i class="mdi mdi-web"></i></span>
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
                    <label class="label" for="logo">Logo</label>
                    <div class="field-body">
                      <div class="image w-48 h-48 mx-auto hidden">
                        
                      </div>
                      <div class="field file">
                        <label class="upload control">
                          <a class="button blue">
                            Upload
                          </a>
                          <input type="file" name="logo" id="logo" required onchange="showImagePreview(event)">
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {{-- <div class="field">
                <div class="field-body">
                  <div class="field">
                    <div class="field addons">
                      <div class="control">
                        <input class="input" value="+44" size="3" readonly="">
                      </div>
                      <div class="control expanded">
                        <input class="input" type="tel" placeholder="Your phone number">
                      </div>
                    </div>
                    <p class="help">Do not enter the first zero</p>
                  </div>
                </div>
              </div>
              <div class="field">
                <label class="label">Department</label>
                <div class="control">
                  <div class="select">
                    <select>
                      <option>Business development</option>
                      <option>Marketing</option>
                      <option>Sales</option>
                    </select>
                  </div>
                </div>
              </div>
              <hr>
              <div class="field">
                <label class="label">Subject</label>
    
                <div class="control">
                  <input class="input" type="text" placeholder="e.g. Partnership opportunity">
                </div>
                <p class="help">
                  This field is required
                </p>
              </div>
    
              <div class="field">
                <label class="label">Question</label>
                <div class="control">
                  <textarea class="textarea" placeholder="Explain how we can help you"></textarea>
                </div>
              </div>
              <hr> --}}
    
              {{-- <div class="field grouped">
                <div class="control">
                  <button type="submit" class="button green">
                    Submit
                  </button>
                </div>
                <div class="control">
                  <button type="reset" class="button red">
                    Reset
                  </button>
                </div>
              </div> --}}
            {{-- </form> --}}
          </div>
        </section>

        <footer class="modal-card-foot">
          <button class="button --jb-modal-close">Cancel</button>
          <button class="button green" type="submit">Submit</button>
        </footer>
      </form>
    {{-- </div> --}}
  </div>
  <div id="add-modal" class="modal">
    <div class="modal-background --jb-modal-close"></div>
    
    {{-- <div class="modal-card"> --}}
      <form method="post" action="{{ route('companies.store') }}" enctype="multipart/form-data" class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Edit</p>
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
                    <label for="company" class="label">Company Name</label>
                    <div class="control icons-left">
                      <input class="input" type="text" placeholder="Company Name" id="company" name="name" required>
                      <span class="icon left"><i class="mdi mdi-account"></i></span>
                    </div>
                  </div>
                  <div class="field">
                    <label for="website" class="label">Website</label>
                    <div class="control icons-left icons-right">
                      <input class="input" type="text" placeholder="Website" value="" id="website" name="website" required>
                      <span class="icon left"><i class="mdi mdi-web"></i></span>
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
                    <label class="label" for="logo">Logo</label>
                    <div class="field-body">
                      <div class="image w-48 h-48 mx-auto hidden">
                        
                      </div>
                      <div class="field file">
                        <label class="upload control">
                          <a class="button blue">
                            Upload
                          </a>
                          <input type="file" name="logo" id="logo" required onchange="showImagePreview(event)" data-modal="add">
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {{-- <div class="field">
                <div class="field-body">
                  <div class="field">
                    <div class="field addons">
                      <div class="control">
                        <input class="input" value="+44" size="3" readonly="">
                      </div>
                      <div class="control expanded">
                        <input class="input" type="tel" placeholder="Your phone number">
                      </div>
                    </div>
                    <p class="help">Do not enter the first zero</p>
                  </div>
                </div>
              </div>
              <div class="field">
                <label class="label">Department</label>
                <div class="control">
                  <div class="select">
                    <select>
                      <option>Business development</option>
                      <option>Marketing</option>
                      <option>Sales</option>
                    </select>
                  </div>
                </div>
              </div>
              <hr>
              <div class="field">
                <label class="label">Subject</label>
    
                <div class="control">
                  <input class="input" type="text" placeholder="e.g. Partnership opportunity">
                </div>
                <p class="help">
                  This field is required
                </p>
              </div>
    
              <div class="field">
                <label class="label">Question</label>
                <div class="control">
                  <textarea class="textarea" placeholder="Explain how we can help you"></textarea>
                </div>
              </div>
              <hr> --}}
    
              {{-- <div class="field grouped">
                <div class="control">
                  <button type="submit" class="button green">
                    Submit
                  </button>
                </div>
                <div class="control">
                  <button type="reset" class="button red">
                    Reset
                  </button>
                </div>
              </div> --}}
            {{-- </form> --}}
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
