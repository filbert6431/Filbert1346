@extends('layout-admin.app')

@section('content')

<h1>Edit Profile</h1>

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @if ($user->profile_picture)
        <img src="{{ Storage::url($user->profile_picture) }}" width="150"><br><br>
    @endif

    <input type="file" name="profile_picture">
    <button type="submit" class="btn btn-success">Update</button>
</form>

<form action="{{ route('profile.destroy') }}" method="POST" class="mt-3">
    @csrf
    @method('DELETE')

    <button class="btn btn-danger">Delete Profile Picture</button>
</form>

@endsection
