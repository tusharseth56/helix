<style>
    .error{
        color:red;
    }
</style>
<form action="{{route('addAccount')}}" method="POST">
@csrf
    Account Id <input type="number" name="account_id">
    @if($errors->has('account_id'))
    <div class="error">{{ $errors->first('account_id') }}</div>
    @endif

    Introducer Id <input type="number" name="introducer_id">
    @if($errors->has('introducer_id'))
    <div class="error">{{ $errors->first('introducer_id') }}</div>
    @endif

    <input type="submit" class="f">
    <br>
    @if(Session::has('message'))
    <div class="error" style="text-align:center;">
        <h4 class="error">{{ Session::get('message') }}</h4>
    </div>

    @endif
</form>