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
                  <v-col cols="12" sm="6" md="12">
                    <v-select
                      :items="categories"
                      :label="$t('category')"
                      dense
                      outlined
                      required
                      :rules="catRules"
                      v-model="form.category_id"
                      item-text="name"
                      item-value="id"
                    ></v-select>
                  </v-col>
                  <v-col cols="12" sm="6" md="12">
                    <v-text-field
                      outlined
                      dense
                      :label="$t('subcategory')"
                      required
                      :rules="subcatRules"
                      v-model="form.name"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="12">
                    <v-textarea
                      outlined
                      dense
                      color="teal"
                      v-model="form.description"
                    >
                      <template v-slot:label>
                        <div>
                          {{ $t("description") }}<small>(optional)</small>
                        </div>
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
        <v-btn dark color="indigo" class="float-right" @click="dialog = true">
          <v-icon left> mdi-plus </v-icon>
          {{ $t("add_subcategory") }}
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
              {{ $t("subcategory_list") }}
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
            <v-data-table :headers="headers" :items="subcategories">
              <template v-slot:item.actions="{ item }">
                <v-btn
                  class="mx-2"
                  dark
                  small
                  color="cyan"
                  @click="editSubCategory(item)"
                >
                  <v-icon dark> mdi-pencil </v-icon>
                </v-btn>
                <v-btn
                  class="mx-2"
                  dark
                  small
                  color="red"
                  @click="deleteSubCategory(item)"
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
  name: "AddSubcategory",
  middleware: "auth",
  head: {
    title: "Add Sub Category",
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
      headline: this.$t("subcategory_add"),
      valid: true,
      catRules: [(v) => !!v || this.$t("catname_is_required")],
      subcatRules: [(v) => !!v || this.$t("subcatname_is_required")],
      dialog: false,
      form: {
        category_id: "",
        name: "",
        description: "",
      },
      subcatid: "",
      direction: "top right",
      categories: [],
      subcategories: [],
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("category"),
          value: "category_name",
        },
        {
          sortable: false,
          text: this.$t("subcategory"),
          value: "name",
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
    this.getSubCategories();
  },
  methods: {
    editSubCategory(item) {
      this.update = true;
      this.dialog = true;
      this.headline = this.$t("subcategory_edit");
      this.form.category_id = item.category_id;
      this.form.name = item.name;
      this.form.description = item.description;
      this.subcatid = item.id;
    },
    deleteSubCategory(item) {
      this.confirmation = true;
      this.subcatid = item.id;
    },
    async confirmDelete() {
      await this.$axios.delete(`sub-category/${this.subcatid}`).then((res) => {
        this.alert = true;
        this.message = "SubCategory Deleted Successfully";
        this.confirmation = false;
        this.getSubCategories();
      });
    },
    async getCategories() {
      await this.$axios.get("/category").then((response) => {
        this.categories = response.data;
      });
    },
    async getSubCategories() {
      await this.$axios.get("/sub-category").then((response) => {
        this.subcategories = response.data;
      });
    },
    async submitForm() {
      if (this.$refs.form.validate()) {
        if (this.update == false) {
          await this.$axios.post("/sub-category", this.form).then((res) => {
            this.form={}
            this.$refs.form.reset()
            this.message = "Subcategory Addedd Successfully";
            this.dialog = false;
            this.alert = true;
            this.getSubCategories();
          });
        } else {
          await this.$axios
            .patch(`sub-category/${this.subcatid}`, this.form)
            .then((res) => {
              this.form={}
              this.$refs.form.reset()
              this.message = "Subcategory Updated successfully";
              this.dialog = false;
              this.alert = true;
              this.getSubCategories();
            });
        }
      }
    },
  },
};
</script>

<style>
</style>
