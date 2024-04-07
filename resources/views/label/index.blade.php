@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __('label.index.header') }}
        </h1>

        @auth
            <div>
                <a href="{{ route('labels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('label.index.create') }}
                </a>
            </div>
        @endauth

        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <th>{{ __('label.index.id') }}</th>
                    <th>{{ __('label.index.name') }}</th>
                    <th>{{ __('label.index.description') }}</th>
                    <th>{{ __('label.index.created_at') }}</th>
                    @auth
                        <th>{{ __('label.index.actions') }}</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach ($labels as $label)
                    <tr class="border-b border-dashed text-left">
                        <td>{{ $label->id }}</td>
                        <td>{{ $label->name }}</td>
                        <td>{{ $label->description }}</td>
                        <td>{{ $label->created_at->format('d.m.Y') }}</td>
                        @auth
                            <td>
                                <a href="{{ route('labels.destroy', $label->id) }}"
                                    data-confirm="{{ __('label.index.delete_confirm') }}"
                                    data-method="DELETE"
                                    class="text-red-600 hover:text-red-900">
                                    {{ __('label.index.delete') }}
                                </a>
                                <a href="{{ route('labels.edit', $label->id) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ __('label.index.edit') }}
                                </a>
                            </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $labels->links() }}
        </div>
    </div>
@endsection
