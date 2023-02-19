<x-app-layout>
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
                                <img src="{{ $request->getBaseUrl().'/images/companies/'.$company->logo }}" alt="" class="w-24">
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
</x-app-layout>
