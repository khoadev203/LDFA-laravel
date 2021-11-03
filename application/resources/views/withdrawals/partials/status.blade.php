@if($withdrawal->Status->id == 1)
<span class="badge badge-success">{{$withdrawal->Status->name}}</span>
@elseif($withdrawal->Status->id == 2)
<span class="badge">{{$withdrawal->Status->name}}</span>
@elseif($withdrawal->Status->id == 3)
<span class="badge badge-info">{{$withdrawal->Status->name}}</span>
@elseif($withdrawal->Status->id == 4)
<span class="badge">{{$withdrawal->Status->name}}</span>
@endif