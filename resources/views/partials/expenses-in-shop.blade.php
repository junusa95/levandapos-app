
<?php $i = 1; ?>
    @if($data['shopExpenses']->isNotEmpty())
    @foreach($data['shopExpenses'] as $value)
        <tr>
            <td>{{$i}}</td>
            <td>
                {{$value->expense->name}}
            </td>  
            <td>
                {{number_format($value->amount, 0)}}
            </td>  
            <td>
                {{$value->description}}
            </td>  
            <td>  
                @if($data['date'] == $data['today'])
                <a href="#" class="btn btn-info btn-sm editExpense" val="{{$value->id}}"><i class="fa fa-edit"></i></a>
                <a href="#" class="btn btn-danger btn-sm deleteExpense" val="{{$value->id}}"><i class="fa fa-times"></i></a>
                @endif
                @if($data['date'] == "" && $data['today'] == "-")
                    {{$value->updated_at}}
                @endif
            </td>
        </tr>


    <?php  $i++; ?>
    @endforeach
    @else
    <tr>
        <td colspan="5" style="text-align: center;">
            <i>No Expenses recorded.</i>
        </td>
    </tr>
    @endif


    @if($data['shopExpenses']->isNotEmpty())
        <tr>
            <th colspan="2">Total</th>
            <th>{{number_format($data['sum'], 0)}}</th>
            <th colspan="2"></th>
            <th></th>
        </tr>
    @endif