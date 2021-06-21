@extends('layouts.app')

@section('content')
    <div id="productsContainer" class="row">
          <div class="col-md-8">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Update Product</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="updateProductForm" @submit.prevent="updateProduct()">
                  <input type="hidden" name="id" value="{{ $id }}">
                  <div class="card-body">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" autocomplete="off" value="{{ $name }}">
                    </div>
                    <div class="form-group">
                      <label>Category</label>
                      <select name="category" class="form-control">
                        <option>{{ $category }}</option>
                        <option>School supplies</option>
                        <option>Office supplies</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" name="description">{{ $description }}</textarea>
                    </div>
                    <div class="form-group">
                      <label>Date & Time</label>
                      <input type="text" class="form-control datetimepicker" name="updateProductDateTime" autocomplete="off" >
                    </div>
                    <div class="form-group">
                      <label>Images</label>
                      <product-photos productId="{{ $id }}"></product-photos>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
          </div>
    </div>
@endsection

@push('products-script')
	<script src="{{ url('js/products.js') }}"></script>
@endpush