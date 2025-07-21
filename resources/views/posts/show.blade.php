@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <img src="/storage/{{ $post->image }}" class="w-100">
            </div>
            <div class="col-4">
                <div>
                    <div class="d-flex align-items-center">
                        <div class="pr-3">
                            <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100"
                                style="max-width: 40px;">
                        </div>
                        <div>
                            <div class="font-weight-bold d-flex align-items-center">
                                <a href="/profile/{{ $post->user->id }}">
                                    <span class="text-dark">{{ $post->user->username }}</span>
                                </a>
                                @if (Auth::user()->id !== $userId)

                                    <follow-button user-id="{{ $userId }}" follows="{{ $follows }}"></follow-button>

                                @else
                                    <form id='delete_post' action="{{route('post.destroy', ['post' => $post])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm ml-4" type="button" onclick="deletePost()">
                                            Delete Post
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>

                    <p>
                        <span class="font-weight-bold">
                            <a href="/profile/{{ $post->user->id }}">
                                <span class="text-dark">{{ $post->user->username }}</span>
                            </a>
                        </span> {{ $post->caption }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

    <script>
        function deletePost() {
            const myForm = document.getElementById('delete_post');
            Swal.fire({
                title: "Are you sure gamer you want to delete?",
                text: 'Action cannot be revert.',
                showCancelButton: true,
                confirmButtonText: "Yes Sir",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    myForm.submit()
                }
            });
        }
    </script>
@endpush