@extends('layouts.app')

@section('content')
    <div id="productsContainer" class="row">
          <div class="col-md-8">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Create Product</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form @submit.prevent="addProduct()" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" id="name" autocomplete="off" v-model="productName">
                    </div>
                    <div class="form-group">
                      <label>Category</label>
                      <select class="form-control" id="category" v-model="productCategory">
                        <option>School supplies</option>
                        <option>Office supplies</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" id="description" v-model="productDescription"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Date & Time</label>
                      <input type="text" class="form-control datetimepicker" id="newProductDateTime" autocomplete="off" >
                    </div>
                    <div class="form-group">
                      <label>Images</label>
                      <input type="file" ref="file" multiple="multiple" @change="storeImage()">
                      <ul class="mt-2">
                        <li v-for="(img, index) in imageArr" class="mt-2">
                          @{{ img.name }} <a href="#" @click.prevent="removeImage(index)" class="ml-2" style="text-decoration: none; color: red;"><i class="fa fa-times"></i></a>
                        </li>
                      </ul>
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