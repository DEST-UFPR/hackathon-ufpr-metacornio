@extends('layouts.l_index')

@section('content')
    <div class="col-12 text-center align-self-center py-5">
        {{-- <iframe title="Hackaton - CPA - Update" width="640" height="250" src="https://app.powerbi.com/reportEmbed?reportId=364a1fd6-6b0f-4628-b1a9-efbf70935a29&autoAuth=true&ctid=9e2efc25-8fb1-4679-aa06-18c31f7e8371" frameborder="0" allowFullScreen="true"></iframe> --}}
        <iframe title="Hackaton - CPA - Disciplinas" width="1480" height="815" src="https://app.powerbi.com/view?r=eyJrIjoiYjU0ZTlkZjgtYTNmMC00MzQwLTkyNmUtYmIzOTc4YzExMjE3IiwidCI6IjllMmVmYzI1LThmYjEtNDY3OS1hYTA2LTE4YzMxZjdlODM3MSJ9" frameborder="0" allowFullScreen="true"></iframe>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    
});
</script>
@endsection