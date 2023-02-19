<x-app-layout>
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
</x-app-layout>
