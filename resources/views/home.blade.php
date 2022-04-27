<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
              
                    {{ __('You are logged in!') }}
                    @hasrole('Admin')
                    <div class="all-stats-div">
                        <div class="col-md-12">	
                            <div class="row">
                            <div class="col-md-4 col-sm-6 card dashboard-count-box m-4">
                                <div class="card-body">
                                    <div class="h1 text-muted text-right mb-4">
                                        <i class="fa fa-users"></i>
                                    </div>	
                                    <div class="h4 mb-0">
                                        <span class="users-count"></span>
                                    </div>
                                    <small class="text-muted  font-weight-bold">Users</small>
                                </div>
                            </div>	
                            <div class="col-md-4 col-sm-6 card dashboard-count-box m-4">
                                <div class="card-body">
                                    <div class="h1 text-muted text-right mb-4">
                                        <i class="fa fa-users"></i>
                                    </div>	
                                    <div class="h4 mb-0">
                                        <span class="test-count"></span>
                                    </div>
                                    <small class="text-muted  font-weight-bold">test</small>
                                </div>
                            </div>	
                            <div class="col-md-4 col-sm-6 card dashboard-count-box m-4">
                                <div class="card-body">
                                    <div class="h1 text-muted text-right mb-4">
                                        <i class="fa-brands fa-product-hunt"></i>
                                    </div>	
                                    <div class="h4 mb-0">
                                        <span class="products-count"></span>
                                    </div>
                                    <small class="text-muted  font-weight-bold">Products</small>
                                </div>
                            </div>	
                        </div>
                        </div>
                    </div>
                    @endhasrole
                   
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

<script>
    if(typeof jQuery!=='undefined'){
    console.log('jQuery Loaded');
}
else{
    console.log('not loaded yet');
}
    
    

    $(document).ready(function(){
    	var type='all';
    	var total='all';
        var token= $('input[name=_token]').val();
        $.ajax({
            url:"{{route('get.stats')}}",
            method:"POST",
            dataType: 'json',
            data:{
                type: type, 
                total: total, 
                _token: token, 
            },
            success: function(data){
                if(data==null || data=='null'){
                } else {
                   console.log(data);
                    $('.users-count').text(data.users);
                    $('.test-count').text(data.tests);
                    $('.products-count').text(data.products);
                   
                }
            },
            error: function(data){
                
                   console.log(data);
                   
                   
                
            }
        });
        

    	
    });

</script>