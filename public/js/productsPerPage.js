new Vue({
  el: '#productsContainer',
  data() {
  	return {
      baseUrl: 'https://localhost/praxy/public',
      products: [],
      productsPerPage: [],
      productName:'',
      productCategory:'',
      productDescription: '',
      searchKeyword: '',
      searchCategory: '',
      paginationPage: 0,
      rowsPerPage: 2
	  }
  },
  mounted()
  {
    this.getProducts();
    this.getProductsPerPage();
    this.pagination();
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
    getProductsPerPage: function()
    {
      axios.get(`${this.baseUrl}/products/page/${paginationPage}`)
        .then((response) => {

          let resp = response.data;

          this.productsPerPage = resp;
        })
        .catch((error) => {
          // handle error
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

      axios.post(`${this.baseUrl}/products/add`, data)
      .then((response) => {

        let resp = response.data;

        if(resp.success === 1)
        {
          $.LoadingOverlay('hide');
          window.location = `${this.baseUrl}/ui`;
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
    updateProductUI: function(productId)
    {
      window.location = `${this.baseUrl}/products/ui/update/${productId}`;
    },
    updateProduct: function()
    {
      $.LoadingOverlay('show');

      let data = new FormData(updateProductForm);

      axios.post(`${this.baseUrl}/products/update`, data)
      .then((response) => {

        let resp = response.data;

        if(resp.success === 1)
        {
          $.LoadingOverlay('hide');
          window.location = `${this.baseUrl}/ui`;
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
    deleteProduct: function(productId)
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

          this.products = resp;

          console.log(this.products);
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

          this.products = resp;
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

          this.paginationPage = resp.length / this.rowsPerPage;

          console.log(this.paginationPage);
        })
        .catch((error) => {
          // handle error
          console.log(error);
        })
    }
  }
});