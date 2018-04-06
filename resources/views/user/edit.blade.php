@extends ('app')

@section ('content')
    <h1>Редактирование информации</h1>
    @include('errors')
    <form action="{{url ('user/update', $user->id)}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label for="email" class="control-label">Email</label>
            <input type="text" class="form-control" name="email" id="email" value="{{ $user->email }}">
        </div>

        <div class="form-group">
            <label for="firstname" class="control-label">Имя</label>
            <input type="text" class="form-control" name="firstname" id="firstname" value="@php if(isset($userInfo)){ echo $userInfo->firstname;} else {echo '';}
            @endphp">
        </div>

        <div class="form-group">
            <label for="lastname" class="control-label">Фамилия</label>
            <input type="text" class="form-control" name="lastname" id="lastname" value="@php if(isset($userInfo)){ echo $userInfo->lastname;} else {echo '';}
            @endphp">
        </div>

        <div class="form-group">
            <label for="patronomyc" class="control-label">Отчество</label>
            <input type="text" class="form-control" name="patronomyc" id="patronomyc" value="@php if(isset($userInfo)){ echo $userInfo->patronomyc;} else {echo '';}
            @endphp">
        </div>

        <div class="form-group">
            <label for="city" class="control-label">Город</label>
            <select name="cities" id="city" class="form-control">
                @foreach($cites as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                    @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="skills" class="control-label">Навыки</label>
            <select name="skill_id[]" id="skills" class="form-control" multiple="multiple">
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    </form>
    @stop

    @section('script')

    <script>
    $(document).ready(function() {
        $('#city').select2({
            placeholder : 'Test!'
        });
        var data = new Array();
        var ids = new Array();
        <?php
        $dataArray = [];
        $ids = [];
        foreach ($user->skill()->get() as $key => $value) {
            if($value == Null){
                continue;
            }
            $dataArray[] = array('id' => $value->id , 'text' => $value->name );
            $ids[] = $value->id;
        }
        $test = json_encode($dataArray);
        $idsArray = json_encode($ids);
        ?>
        data = <?= $test ?>;
        ids = <?= $idsArray?>;
        $('#skills').select2({
            data : data,
        });
        $('#skills').val(ids).trigger('change');
        $('#skills').select2({
            placeholder : 'Выберите свои навыки...',
            tags : true,
            ajax : {
                url : '/user/search',
                dataType: 'json',
                delay: 200,
                data: function (params) {
                    return {
                        q : params.term,
                        page: params.page
                    };
                },
                processResults : function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.data, function (item) {
                           return {
                               text: item.name,
                               id: item.id
                           };
                        }),
                        pagination : {
                            more : (params.page * 10) < data.total
                        }
                    };
                },
            }
        });
        
        });
</script>
    @stop