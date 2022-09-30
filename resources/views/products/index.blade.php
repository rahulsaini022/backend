@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Products</h2>
            </div>
            <div class="pull-right">
                @can('product-create')
                <a class="btn btn-success" href="{{ route('products.create',Auth::user()->roles[0]->name) }}"> Create New Product</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
    <script>  Toast.fire({icon: 'success',title: '{{$message}}'})</script>
  @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($products as $product)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $product->name }}</td>
	        <td>{{ $product->detail }}</td>
	        <td>
                <form action="{{ url(Auth::user()->roles[0]->name.'/products/'.$product->id) }}" method="POST">
                    <a class="btn btn-info" href="{{url(Auth::user()->roles[0]->name.'/products/'.$product->id)  }}">Show</a>
                    @can('product-edit')
                    <a class="btn btn-primary" href="{{ url(Auth::user()->roles[0]->name.'/products/'.$product->id.'/edit') }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('product-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $products->links() !!}



@endsection