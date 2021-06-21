@extends('layouts.app')

@section('content')
    <div id="productsContainer" class="row">
    	<div class="col-md-12">
	    	<div class="row pb-2 text-right">
	    		<div class="col-md-5">
					<div class="input-group mb-3">
					  <input type="text" class="form-control" placeholder="Search keywords" v-model="searchKeyword">
					  <div class="input-group-append">
					    <button class="btn btn-outline-secondary" type="button" @click="searchProduct()">Click to Search</button>
					  </div>
					</div>
	    		</div>
	    		<div class="col-md-3">
	    			<select class="form-control" v-model="searchCategory" @change="searchCategoryNow()">
	    				<option value="">Filter by Category</option>
                        <option value="School supplies">School supplies</option>
                        <option value="Office supplies">Office supplies</option>
	    			</select>
	    		</div>
	    		<div class="col-md-4">
	    			<form method="GET" action="{{ url('/dashboard/products/add') }}">
	    				<button class="btn btn-success"><i class="fa fa-plus"></i> Create</button>
	    			</form>
	    		</div>
	    	</div>
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Date & Time</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
	              <tr v-for="prod in productsPerPage" :key="prod.id">
	                <td> @{{ prod.name }} </td>
	                <td> @{{ prod.category }} </td>
	                <td> @{{ prod.description }} </td>
	                <td> @{{ prod.date_time }} </td>
	                <td>
	                	<button class="btn btn-success" @click="updateProductUI(prod.id, prod.name, prod.category, prod.description)">
	                		<i class="fa fa-pencil-alt"></i>
	                	</button>

	                	<button class="btn btn-danger" @click="deleteProduct(prod.id)">
	                		<i class="fa fa-trash"></i>
	                	</button>
	                </td>
	              </tr>
          	  </tbody>
            </table>
            <div class="col-md-12 text-right">
            	<span v-for="page in totalPages">
	            	<a href="#" :id="'page'+page" class="mr-2 pages"  style="text-decoration: none; font-size: 20px;" @click.prevent="selectPage(page)">
	            		@{{ page }}
	            	</a>
            	</span>
            </div>
    	</div>
    </div>
@endsection

@push('products-script')
	<script src="{{ url('js/products.js') }}"></script>
@endpush