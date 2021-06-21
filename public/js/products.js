new Vue({
  el: '#productsContainer',
  data() {
  	return {
      baseUrl: 'https://localhost/praxy/public',
      productId: '',
      products: [],
      productsPerPage: [],
      productName:'',
      productCategory:'',
      productDescription: '',
      searchKeyword: '',
      searchCategory: '',
      paginationPage: 0,
      rowsPerPage: 5,
      totalPages: 0,
      currentPage: 'currentPage',
      imageArr: []
	  }
  },
  mounted()
  {
    // this.getProducts();
    this.getProductsPerPage();
    this.pagination();
    console.log(this.productId);
  },
  methods: {
  	getProducts: function ()
  	{

      axios.get(`${this.baseUrl}/products`)
        .then((response) => {

          let resp = response.data;

          this.products = resp;
        })
        .catch((error) => {
          // handle error
          console.log(error);
        })
    },
    getProductsPerPage: function(start, limit)
    {
      let data = {
        start: this.paginationPage,
        limit: this.rowsPerPage
      }

      axios.post(`${this.baseUrl}/products/page`, data)
        .then((response) => {

          let resp = response.data;

          this.productsPerPage = resp;
        })
        .catch((error) => {

          console.log(error);
        })
    },
    selectPage: function(page)
    {
      this.paginationPage = page;

      let data = {
        start: this.paginationPage,
        limit: this.rowsPerPage
      }

      axios.post(`${this.baseUrl}/products/page`, data)
        .then((response) => {

          let resp = response.data;

          this.productsPerPage = resp;
        })
        .catch((error) => {

          console.log(error);
        })
    },
    addProduct: function()
    {
      $.LoadingOverlay('show');

      let name = this.productName;
      let category = this.productCategory;
      let description = this.productDescription;
      let dateTime = $('#newProductDateTime').val();

      let data = {
        name: name,
        category: category,
        description: description,
        dateTime: dateTime
      }

      let formData = new FormData();
      formData.append('name', name);
      formData.append('category', category);
      formData.append('description', description);
      formData.append('dateTime', dateTime);

      let no = 0;
      for(let img of this.imageArr)
      {
        formData.append(`img${no}`, img);
        no++;
      }

      formData.append('fileNo', no);

      axios.post(`${this.baseUrl}/products/add`, formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        },
      })
      .then((response) => {

        let resp = response.data;

        if(resp.success === 1)
        {
          $.LoadingOverlay('hide');
          window.location = `${this.baseUrl}/dashboard`;
        }else
        {
          console.log(error);
        }

      })
      .catch((error) => {
        $.LoadingOverlay('hide');
        console.log(error);
      })
    },
    storeImage: function()
    {
      for( var i = 0; i < this.$refs.file.files.length; i++ )
      {
          let file = this.$refs.file.files[i];
          this.imageArr.push(file);
          console.log(this.imageArr);
      }
    },
    storeImageUpdate: function(productId)
    {
      console.log(productId);
    },
    removeImage: function(index)
    {
        console.log(index);
        this.imageArr.splice(index, 1);
    },
    updateProductUI: function(productId)
    {
      window.location = `${this.baseUrl}/dashboard/products/update/${productId}`;
    },
    updateProduct: function()
    {
      $.LoadingOverlay('show');

      let data = new FormData(updateProductForm);

      let no = 0;
      for(let img of this.imageArr)
      {
        data.append(`img${no}`, img);
        no++;
      }

      data.append('fileNo', no);

      axios.post(`${this.baseUrl}/products/update`, data)
      .then((response) => {

        let resp = response.data;

        if(resp.success === 1)
        {
          $.LoadingOverlay('hide');
          window.location = `${this.baseUrl}/dashboard`;
        }else
        {
          $.LoadingOverlay('hide');
          console.log(resp.error);
        }

      })
      .catch((error) => {
        $.LoadingOverlay('hide');
        console.log(error);
        this.getProducts();
      })

    },
    deleteProduct: function(productId, page)
    {
      $.LoadingOverlay('show');

      let data = {
        id: productId
      };

      axios.post(`${this.baseUrl}/products/delete`, data)
      .then((response) => {

        let resp = response.data;

        if(resp.success === 1)
        {
          $.LoadingOverlay('hide');
          this.getProducts();
        }else
        {
          console.log(error);
          this.getProducts();
        }

      })
      .catch((error) => {
        $.LoadingOverlay('hide');
        console.log(error);
        this.getProducts();
      })

    },
    searchProduct: function()
    {
      let data = {
        keywords: this.searchKeyword
      }

      axios.post(`${this.baseUrl}/products/search`, data)
        .then((response) => {

          let resp = response.data;

          this.productsPerPage = resp;

          console.log(this.productsPerPage);
        })
        .catch((error) => {
          // handle error
          console.log(error);
        })
    },
    searchCategoryNow: function()
    {
      let data = {
        category: this.searchCategory
      }

      if(this.searchCategory !== '')
      {
        axios.post(`${this.baseUrl}/products/category/search`, data)
        .then((response) => {

          let resp = response.data;

          this.productsPerPage = resp;
        })
        .catch((error) => {
          // handle error
          console.log(error);
        })
      }else
      {
        this.getProducts();
      }
    },
    pagination: function()
    {
      axios.get(`${this.baseUrl}/products`)
        .then((response) => {

          let resp = response.data;

          this.totalPages = resp.length % this.rowsPerPage;

          console.log(this.paginationPage);
        })
        .catch((error) => {
          // handle error
          console.log(error);
        })
    }
  }
});