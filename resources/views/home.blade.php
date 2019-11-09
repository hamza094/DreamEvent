@extends('layouts.app')

@section('content')
  <div class="">
                

                <div class="">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
             </div>
            </div>
@endsection
