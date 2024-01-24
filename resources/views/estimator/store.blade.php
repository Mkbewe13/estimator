<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('estimations.store') }}">
            @csrf
            <label for="name">Name</label>
            <textarea
                name="name"
                style="height: 5vh"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <br>

            <label for="description">Description</label>
            <textarea
                name="description"
                placeholder="{{ __('A few sentences generally describing the application and its main assumptions.') }}"
                style="height: 20vh"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <br>
            <label for="userflow">Userflow</label>
            <textarea
                name="userflow"
                placeholder="{{ __('Description of userflow of application actions from end user and admin perspective.') }}"
                style="height: 30vh"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <br>
            <label for="requirements">Requirements</label>
            <textarea
                name="requirements"
                placeholder="{{ __('List of all functionalities and requirements from the client.
Descriptions should be as specific as possible') }}"
                style="height: 30vh"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>
