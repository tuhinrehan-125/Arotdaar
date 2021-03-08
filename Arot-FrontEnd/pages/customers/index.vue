<template>
  <v-container fluid grid-list-xl class="mt-5">
    <v-row justify="center">
      <base-material-snackbar
        v-model="alert"
        v-for="(error, k) in message"
        :key="k"
        :type="type"
        v-bind="{
          [parsedDirection[0]]: true,
          [parsedDirection[1]]: true,
        }"
      >
        <div v-for="(err, i) in error" :key="i">{{ err }}</div>
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
                  <v-col cols="12">
                    <v-text-field
                      outlined
                      dense
                      :label="$t('customer_name')"
                      :rules="nameRules"
                      required
                      v-model="form.name"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-textarea
                      outlined
                      dense
                      color="teal"
                      rows="2"
                      v-model="form.address"
                    >
                      <template v-slot:label>
                        <div>{{ $t("customer_address") }}</div>
                      </template>
                    </v-textarea>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      :label="$t('mobile_no')"
                      outlined
                      dense
                      type="number"
                      v-model="form.mobile_no"
                      :rules="[phonerules.required, phonerules.min]"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      :label="$t('alt_mobile_no')"
                      outlined
                      dense
                      type="number"
                      v-model="form.alt_mobile_no"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      :label="$t('shop_name')"
                      outlined
                      dense
                      v-model="form.shop_name"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      :label="$t('shop_address')"
                      outlined
                      dense
                      v-model="form.shop_address"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      :label="$t('nid_no')"
                      required
                      outlined
                      dense
                      :rules="nidRules"
                      v-model="form.nid_no"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-file-input
                      :label="$t('nid_image')"
                      outlined
                      dense
                      v-model="form.nid_image"
                    ></v-file-input>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-file-input
                      :label="$t('customer_image')"
                      outlined
                      dense
                      v-model="form.customer_img"
                    ></v-file-input>
                  </v-col>

                  <v-col cols="12" sm="6" md="6">
                    <v-text-field
                      outlined
                      dense
                      :label="$t('introducer_name')"
                      v-model="form.introducer_name"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-text-field
                      outlined
                      dense
                      type="number"
                      :label="$t('intro_mobile_no')"
                      v-model="form.intro_mobile_no"
                    ></v-text-field>
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
            <v-btn color="blue darken-1" text @click="addCustomer">
              {{ $t("save") }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="view" max-width="600">
        <v-card>
          <v-toolbar dark color="primary">
            <v-toolbar-title>Customer Full View</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn dark text @click="view = false">
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="6" sm="6" md="6">Customer Image </v-col>
                <v-col cols="6" sm="6" md="6">
                  <img
                    :src="form.customer_img"
                    style="width: 100px; height: 100px"
                  />
                </v-col>
                <v-col cols="6" sm="6" md="6">Customer Name </v-col>
                <v-col cols="6" sm="6" md="6">
                  {{ form.name }}
                </v-col>
                <v-col cols="6" sm="6" md="6"> Address </v-col>
                <v-col cols="6" sm="6" md="6">
                  {{ form.address }}
                </v-col>
                <v-col cols="6" sm="6" md="6"> Mobile No </v-col>
                <v-col cols="6" sm="6" md="6">
                  {{ form.mobile_no }}
                </v-col>
                <v-col cols="6" sm="6" md="6">Alt Mobile No </v-col>
                <v-col cols="6" sm="6" md="6">
                  {{ form.alt_mobile_no }}
                </v-col>
                <v-col cols="6" sm="6" md="6"> Shop Name </v-col>
                <v-col cols="6" sm="6" md="6">
                  {{ form.shop_name }}
                </v-col>
                <v-col cols="6" sm="6" md="6"> Shop Address </v-col>
                <v-col cols="6" sm="6" md="6">
                  {{ form.shop_address }}
                </v-col>
                <v-col cols="6" sm="6" md="6"> Nid No </v-col>
                <v-col cols="6" sm="6" md="6">
                  {{ form.nid_no }}
                </v-col>
                <v-col cols="6" sm="6" md="6"> Nid Image </v-col>
                <v-col cols="6" sm="6" md="6">
                  <img
                    :src="form.nid_image"
                    style="width: 100px; height: 100px"
                  />
                </v-col>
                <v-col cols="6" sm="6" md="6"> Introducer name </v-col>
                <v-col cols="6" sm="6" md="6">
                  {{ form.introducer_name }}
                </v-col>
                <v-col cols="6" sm="6" md="6"> Introducer Mobile No </v-col>
                <v-col cols="6" sm="6" md="6">
                  {{ form.intro_mobile_no }}
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
        </v-card>
      </v-dialog>
      <!-- view customer -->
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
      <!-- end view customer -->
    </v-row>
    <v-row>
      <v-col>
        <v-btn dark color="indigo" class="float-right" @click="dialog = true">
          <v-icon left> mdi-plus </v-icon>
          {{ $t("add_customer") }}
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
            {{ $t("customer_list") }}
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
            <v-data-table
              :headers="headers"
              :items="customers"
              :search="search"
            >
              <template v-slot:item.actions="{ item }">
                <v-btn
                  class="mx-2"
                  dark
                  small
                  color="cyan"
                  @click="editCustomer(item)"
                >
                  <v-icon dark> mdi-pencil </v-icon>
                </v-btn>
                <v-btn
                  class="mx-2"
                  dark
                  small
                  color="light-green darken-1"
                  @click="showCustomer(item)"
                >
                  <v-icon dark> mdi-eye </v-icon>
                </v-btn>
                <v-btn
                  class="mx-2"
                  dark
                  small
                  color="red"
                  @click="deleteCustomer(item)"
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
  name: "Customers",
  middleware: "auth",
  head: {
    title: "Customers",
  },
  components: {},
  data() {
    return {
      valid: true,
      search: "",
      isLoading: false,
      update: false,
      alert: false,
      dialog: false,
      confirmation: false,
      message: null,
      view: false,
      type: "success",
      headline: this.$t("add_customer"),
      phonerules: {
        required: (value) => !!value || this.$t("required"),
        min: (v) => (v && v.length == 11) || this.$t("11_digit_required")
      },
      nidRules: [(v) => !!v || this.$t("required")],
      nameRules: [(v) => !!v || this.$t("required")],
      form: {
        name: "",
        address: "",
        mobile_no: "",
        alt_mobile_no: "",
        shop_name: "",
        shop_address: "",
        nid_no: "",
        nid_image: null,
        customer_img: null,
        introducer_name: "",
        intro_mobile_no: "",
      },
      direction: "top right",
      customers: [],
    };
  },
  computed: {
    headers() {
      return [
        {
          text: this.$t("customer_name"),
          value: "name",
        },
        {
          text: this.$t("address"),
          value: "address",
        },
        {
          text: this.$t("phone_no"),
          value: "mobile_no",
        },
        {
          text: this.$t("shop_name"),
          value: "shop_name",
        },
        {
          text: this.$t("nid_no"),
          value: "nid_no",
        },
        {
          text: this.$t("introducer_name"),
          value: "introducer_name",
        },
        {
          text: this.$t("intro_mobile_no"),
          value: "intro_mobile_no",
        },
        {
          text: this.$t("date"),
          value: "created_at",
        },
        {
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
    this.getCustomers();
  },
  methods: {
    async getCustomers() {
      this.isLoading = true;
      await this.$axios.get("/customer").then((response) => {
        this.isLoading = false;
        this.customers = response.data;
      });
    },
    showCustomer(item) {
      this.view = true;
      this.headline = this.$t("view_customer");
      this.form.name = item.name;
      this.form.address = item.address;
      this.form.mobile_no = item.mobile_no;
      this.form.alt_mobile_no = item.alt_mobile_no;
      this.form.shop_name = item.shop_name;
      this.form.shop_address = item.shop_address;
      this.form.nid_no = item.nid_no;
      this.form.introducer_name = item.introducer_name;
      this.form.nid_image = item.nid_image;
      this.form.customer_img = item.customer_img;
      this.form.intro_mobile_no = item.intro_mobile_no;
    },
    editCustomer(item) {
      this.update = true;
      this.dialog = true;
      this.headline = this.$t("edit_customer");
      this.form.name = item.name;
      this.form.address = item.address;
      this.form.mobile_no = item.mobile_no;
      this.form.alt_mobile_no = item.alt_mobile_no;
      this.form.shop_name = item.shop_name;
      this.form.shop_address = item.shop_address;
      this.form.nid_no = item.nid_no;
      this.form.introducer_name = item.introducer_name;
      this.form.intro_mobile_no = item.intro_mobile_no;
      this.customerid = item.id;
    },
    deleteCustomer(item) {
      this.confirmation = true;
      this.customerid = item.id;
    },
    async confirmDelete() {
      await this.$axios.delete(`customer/${this.customerid}`).then((res) => {
        this.alert = true;
        this.type = "success";
        this.message = { msg: ["Customer Deleted Successfully"] };
        this.confirmation = false;
        this.getCustomers();
      });
    },
    async addCustomer() {
      if (this.$refs.form.validate()) {
        if (this.update == false) {
          let formData = new FormData();
          formData.append("name", this.form.name);
          formData.append("address", this.form.address);
          formData.append("mobile_no", this.form.mobile_no);
          formData.append("alt_mobile_no", this.form.alt_mobile_no);
          formData.append("shop_name", this.form.shop_name);
          formData.append("shop_address", this.form.shop_address);
          formData.append("nid_no", this.form.nid_no);
          formData.append("nid_image", this.form.nid_image);
          formData.append("customer_img", this.form.customer_img);
          formData.append("introducer_name", this.form.introducer_name);
          formData.append("intro_mobile_no", this.form.intro_mobile_no);
          await this.$axios
            .post("customer", formData, {
              headers: {
                "Content-Type": "multipart/form-data",
              },
            })
            .then((res) => {
              this.form = {};
              this.$refs.form.reset();
              this.type = "success";
              this.message = { msg: ["Customer Addedd Successfully"] };
              this.dialog = false;
              this.alert = true;
              this.getCustomers();
            })
            .catch((err) => {
              if (err.response.status == 422) {
                this.alert = true;
                this.type = "error";
                this.errormsg = true;
                this.message = err.response.data.error;
              } else {
                this.type = "error";
                this.message = {
                  msg: ["Something went wrong, Please try again later"],
                };
                this.type = "error";
                this.alert = true;
              }
            });
        } else {
          let formData = new FormData();
          formData.append("name", this.form.name);
          formData.append("address", this.form.address);
          formData.append("mobile_no", this.form.mobile_no);
          formData.append("alt_mobile_no", this.form.alt_mobile_no);
          formData.append("shop_name", this.form.shop_name);
          formData.append("shop_address", this.form.shop_address);
          formData.append("nid_no", this.form.nid_no);
          formData.append("nid_image", this.form.nid_image);
          formData.append("customer_img", this.form.customer_img);
          formData.append("introducer_name", this.form.introducer_name);
          formData.append("intro_mobile_no", this.form.intro_mobile_no);
          formData.append("_method", "PATCH");
          await this.$axios
            .post(`customer/${this.customerid}`, formData, {
              headers: {
                "Content-Type": "multipart/form-data",
              },
            })
            .then((res) => {
              this.form = {};
              this.dialog = false;
              this.alert = true;
              this.type = "success";
              this.message = { msg: ["Customer Updated Successfully"] };
              this.getCustomers();
            });
        }
      }
    },
  },
};
</script>

<style>
</style>
