<template>
  <v-container fluid grid-list-xl class="mt-5">
    <v-row justify="center">
      <base-material-snackbar
        v-model="alert"
        type="success"
        v-bind="{
          [parsedDirection[0]]: true,
          [parsedDirection[1]]: true,
        }"
      >
        {{ message }}
      </base-material-snackbar>

      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
          <v-toolbar dark color="primary">
            <v-toolbar-title>{{ headline }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn dark text @click="dialog = false">
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-card-text>
            <v-container>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-row>
                  <v-col cols="12" sm="12" md="12">
                    <v-select
                      :items="categories"
                      :label="$t('category')"
                      dense
                      outlined
                      required
                      :rules="catRules"
                      item-text="name"
                      item-value="id"
                      v-model="form.category_id"
                    ></v-select>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="12"
                    md="12"
                    v-if="subcategories.length > 0"
                  >
                    <v-select
                      :items="subcategories"
                      :label="$t('subcategory')"
                      dense
                      outlined
                      item-text="name"
                      item-value="id"
                      v-model="form.subcategory_id"
                    ></v-select>
                  </v-col>
                  <v-col cols="12" sm="12" md="12">
                    <v-text-field
                      outlined
                      dense
                      :label="$t('product_name')"
                      required
                      v-model="form.name"
                      :rules="nameRules"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12" md="12">
                    <v-file-input
                      :label="$t('product_image')"
                      outlined
                      v-model="form.image"
                      dense
                    ></v-file-input>
                  </v-col>
                  <v-col cols="12" sm="12" md="12">
                    <v-textarea
                      outlined
                      dense
                      color="teal"
                      v-model="form.details"
                    >
                      <template v-slot:label>
                        <div>{{ $t("product_details") }}</div>
                      </template>
                    </v-textarea>
                  </v-col>

                </v-row>
              </v-form>
            </v-container>
            <small>{{ $t("indicates_required_field") }}</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="dialog = false">
              {{ $t("close") }}
            </v-btn>
            <v-btn color="blue darken-1" text @click="submitForm">
              {{ $t("save") }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="confirmation" max-width="300">
        <v-card>
          <v-card-title>
            Are you sure?
            <v-spacer />
            <v-icon aria-label="Close" @click="confirmation = false">
              mdi-close
            </v-icon>
          </v-card-title>
          <v-card-text class="pb-6 pt-12 text-center">
            <v-btn class="mr-3" text @click="confirmation = false"> No </v-btn>
            <v-btn color="success" text @click="confirmDelete()"> Yes </v-btn>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-row>
    <v-row>
      <v-col>
        <v-btn color="indigo" dark class="float-right" @click="dialog = true">
          <v-icon left> mdi-plus </v-icon>
          {{ $t("add_product") }}
        </v-btn>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="12">
         <v-card v-if="isLoading">
          <v-skeleton-loader class="mx-auto" type="table"></v-skeleton-loader>
        </v-card>
        <v-card v-else>
          <v-card-title>
            {{ $t("product_list") }}
            <v-spacer></v-spacer>
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
            ></v-text-field>
          </v-card-title>
          <v-card-text>
            <v-data-table :headers="headers" :items="productslist" :search="search">
              <template v-slot:item.image="{ item }">
                <img
                  class="product-img"
                  :src="item.image"
                  style="width: 50px; height: 50px"
                />
              </template>

              <template v-slot:item.actions="{ item }">
                <v-btn
                  class="mx-2"
                  dark
                  small
                  color="cyan"
                  @click="editProduct(item)"
                >
                  <v-icon dark> mdi-pencil </v-icon>
                </v-btn>
                <v-btn
                  class="mx-2"
                  dark
                  small
                  color="red"
                  @click="deleteProduct(item)"
                >
                  <v-icon dark> mdi-delete </v-icon>
                </v-btn>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Products",
  middleware: "auth",
  head: {
    title: "Product Add",
  },
  components: {},
  data() {
    return {
      search:'',
      isLoading:false,
      update: false,
      alert: false,
      dialog: false,
      confirmation: false,
      message: "",
      headline: this.$t("add_product"),
      valid: true,
      catRules: [(v) => !!v || this.$t("category_is_required")],
      nameRules: [(v) => !!v || this.$t("product_name_is_required")],
      direction: "top right",
      form: {
        category_id: "",
        subcategory_id: "",
        name: "",
        details: "",
        unit_id: "",
        weight: "",
        price: "",
        image: null,
      },
      prodid: "",
      categories: [],
      productslist: [],
      categories: [],
      subcategories: [],
      units: [],
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("image"),
          value: "image",
        },
        {
          sortable: false,
          text: this.$t("product_name"),
          value: "name",
        },
        {
          sortable: false,
          text: this.$t("category"),
          value: "category_name",
        },
        {
          sortable: false,
          text: this.$t("action"),
          value: "actions",
        },
      ];
    },
    parsedDirection() {
      return this.direction.split(" ");
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getCategories();
    this.getProducts();
  },
  methods: {
    async getCategories() {
      await this.$axios.get("/category").then((response) => {
        this.categories = response.data;
      });
    },
    editProduct(item) {
      this.update = true;
      this.dialog = true;
      this.headline = this.$t("edit_product");
      this.form.name = item.name;
      this.form.details = item.details;
      this.form.category_id = item.category_id;
      this.form.subcategory_id = item.subcategory_id;
      this.prodid = item.id;
    },
    deleteProduct(item) {
      this.confirmation = true;
      this.prodid = item.id;
    },
    async confirmDelete() {
      await this.$axios.delete(`product/${this.prodid}`).then((res) => {
        this.alert = true;
        this.message = "Product Deleted Successfully";
        this.confirmation = false;
        this.getProducts();
      });
    },
    async getProducts() {
      this.isLoading=true
      await this.$axios.get("/product").then((response) => {
         this.isLoading=false
        this.productslist = response.data;
      });
    },
    async getUnit() {
      await this.$axios.get("/unit").then((response) => {
        this.units = response.data;
      });
    },

    async submitForm() {
      if (this.$refs.form.validate()) {
        if (this.update == false) {
          let formData = new FormData();
          formData.append("category_id", this.form.category_id);
          formData.append("subcategory_id", this.form.subcategory_id);
          formData.append("name", this.form.name);
          formData.append("details", this.form.details);
          formData.append("image", this.form.image);
          await this.$axios
            .post("product", formData, {
              headers: {
                "Content-Type": "multipart/form-data",
              },
            })
            .then((res) => {
              this.message = "Product Addedd Successfully";
              this.dialog = false;
              this.alert = true;
              this.getProducts();
            });
        } else {
          let formData = new FormData();
          formData.append("category_id", this.form.category_id);
          formData.append("subcategory_id", this.form.subcategory_id);
          formData.append("name", this.form.name);
          formData.append("details", this.form.details);
          formData.append("image", this.form.image);
          formData.append("_method", "PATCH");
          await this.$axios
            .post(`product/${this.prodid}`, formData, {
              headers: {
                "Content-Type": "multipart/form-data",
              },
            })
            .then((res) => {
              this.message = "Product Updated Successfully";
              this.dialog = false;
              this.alert = true;
              this.getProducts();
            });
        }
          this.form.category_id='';
          this.form.subcategory_id='';
          this.form.name='';
          this.form.details='';
          this.form.image='';
          this.$refs.form.reset()
      }
    },
    async getChildOfCategory(val) {
      await this.$axios.get(`get-subcategories/${val}`).then((response) => {
        this.subcategories = response.data;
      });
    },
  },
  watch: {
    "form.category_id": function (val) {
      this.getChildOfCategory(val);
    },
  },
};
</script>

<style lang="scss" scoped>
.product-img {
  margin: 5px;
  border-radius: 5px;
}
</style>

