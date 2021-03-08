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
            <v-toolbar-title> {{ $t("add_collection") }}</v-toolbar-title>
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
                  <v-col cols="12" sm="4" md="4">
                    <div class="cinfobox">
                      <p>{{ $t("customer_name") }}:</p>
                      <p>{{ collectioninfo.customername }}</p>
                    </div>
                  </v-col>
                  <v-col cols="12" sm="4" md="4">
                    <div class="cinfobox">
                      <p>{{ $t("product_name") }}:</p>
                      <p>{{ collectioninfo.productname }}</p>
                    </div>
                  </v-col>
                  <v-col cols="12" sm="4" md="4">
                    <div class="cinfobox">
                      <p>{{ $t("total_amount") }}:</p>
                      <p>{{ collectioninfo.dueamount }}</p>
                    </div>
                  </v-col>

                  <v-col cols="12" sm="6" md="6">
                    <v-text-field
                      :label="$t('amount')"
                      type="number"
                      outlined
                      dense
                      required
                      :rules="amountRules"
                      v-model="form.amount"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-select
                      :items="payment_method"
                      :label="$t('select_payment_method')"
                      dense
                      outlined
                      required
                      :rules="paymentRules"
                      v-model="form.payment_method"
                    ></v-select>
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
            <v-icon aria-label="Close" @click="dialog3 = false">
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
      <v-col cols="12" md="12">
        <v-card v-if="isLoading">
          <v-skeleton-loader class="mx-auto" type="table"></v-skeleton-loader>
        </v-card>
        <v-card v-else>
          <v-card-title>
            {{ $t("collection_list") }}
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
            <v-data-table :headers="headers" :items="items" :search="search">
              <template v-slot:item.customer_name="{ item }" v-slot:item.id="{item}">
                  <NuxtLink :to="{name: 'collection-history-id',params: { id: item.id }}">{{item.customer_name}}</NuxtLink>
              </template>
              <!-- <template v-slot:item.payment_status="{ item }">
                <v-chip
                  color="success"
                  label
                  v-if="item.payment_status == 'Paid'"
                  >{{ $t("paid") }}</v-chip
                >
                <v-chip
                  color="primary"
                  label
                  v-if="item.payment_status == 'Partial'"
                >
                  {{ $t("partial") }}</v-chip
                >
                <v-chip color="error" label v-if="item.payment_status == 'Due'">
                  {{ $t("due") }}</v-chip
                >
              </template> -->
              <!-- <template v-slot:item.actions="{ item }">
                <v-menu offset-y>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn color="primary" dark v-bind="attrs" v-on="on" small>
                      Action
                      <v-icon right dark> mdi-menu-down </v-icon>
                    </v-btn>
                  </template>
                  <v-list class="actionlist">
                    <v-list-item v-if="item.payment_due > 0">
                      <v-list-item-title @click="addPayment(item)"
                        >Add Collection</v-list-item-title
                      >
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-title>View Payment</v-list-item-title>
                    </v-list-item>
                    <v-list-item
                      :to="{
                        name: 'collection-history-id',
                        params: { id: item.customer_id },
                      }"
                    >
                      <v-list-item-title>{{ $t("collection_history") }}</v-list-item-title>
                    </v-list-item>
                  </v-list>
                </v-menu>
              </template> -->
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Collection",
  middleware: "auth",
  head: {
    title: "Collection",
  },
  components: {},
  data() {
    return {
      search:'',
      isLoading: false,
      customers: [],
      paidAmount: 0,
      collectioninfo: {},
      confirmation: false,
      update: false,
      headline: this.$t("add_collection"),
      alert: false,
      valid: true,
      message: "",
      nameRules: [(v) => !!v || "Name is required"],
      paymentRules: [(v) => !!v || "Payment Method is required"],
      amountRules: [(v) => !!v || "Amount is required"],
      dialog: false,
      form: {
        customer_id: "",
        payment_method: "Cash",
        order_product_id: "",
        amount: 0,
      },
      isCollection: false,
      dueamount: 0,
      collectionid: "",
      direction: "top right",
      payment_method: ["bKash", "Bank", "Cash"],
      categories: [],
      items: [],
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("customer_name"),
          value: "customer_name",
        },
        {
          sortable: false,
          text: this.$t("mobile_no"),
          value: "mobile_no",
        },
        {
          sortable: false,
          text: this.$t("total_purchase"),
          value: "ordered",
        },
        {
          sortable: false,
          text: this.$t("paid"),
          value: "paid",
        },
        {
          sortable: false,
          text: this.$t("due"),
          value: "due",
        },
        // {
        //   sortable: false,
        //   text: this.$t("action"),
        //   value: "actions",
        // },
      ];
    },
    parsedDirection() {
      return this.direction.split(" ");
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getCustomers();
    this.getCollection();
  },
  methods: {
    async getCustomers() {
      await this.$axios.get("/customer").then((response) => {
        this.customers = response.data;
      });
    },
    async addPayment(item) {
      this.collectioninfo.customername = item.customer_name;
      this.collectioninfo.customername = item.customer_name;
      this.collectioninfo.productname = item.product;
      this.collectioninfo.dueamount = item.payment_due;
      this.dialog = true;
      this.form.amount = item.payment_due;
      this.form.customer_id = item.customer_id;
      this.form.order_product_id = item.order_product_id;
    },
    async getCollection() {
      this.isLoading = true;
      await this.$axios.get("/collection").then((response) => {
        this.isLoading = false;
        this.items = response.data;
      });
    },
    deleteCollection(item) {
      this.confirmation = true;
      this.collectionid = item.id;
    },
    async confirmDelete() {
      await this.$axios
        .delete(`collection/${this.collectionid}`)
        .then((res) => {
          this.alert = true;
          this.message = "Collection Deleted Successfully";
          this.confirmation = false;
          this.getCollection();
        });
    },
    editCollection(item) {
      this.update = true;
      this.dialog = true;
      this.headline = this.$t("collection_edit");
      this.form.customer_id = item.customer_id;
      this.form.amount = item.amount;
      this.form.payment_method = item.payment_method;
      this.collectionid = item.id;
    },
    async submitForm() {
      if (this.$refs.form.validate()) {
        if (this.update == false) {
          await this.$axios.post("/collection", this.form).then((res) => {
            this.message = "Collection Added Successfully";
            this.dialog = false;
            this.alert = true;
            this.getCollection();
          });
        } else {
          await this.$axios
            .patch(`collection/${this.collectionid}`, this.form)
            .then((res) => {
              this.message = "Collection Updated successfully";
              this.dialog = false;
              this.alert = true;
              this.getCollection();
            });
        }
      }
    },
  },
  watch: {
    "form.customer_id": function (val) {
      this.$axios
        .get("/customer-due?customer=" + val)
        .then((res) => {
          if (res.data.dueamount > 0) {
            this.isCollection = true;
            this.dueamount = res.data.dueamount;
          }
        })
        .catch((err) => {
          this.isCollection = false;
          console.log(err);
        });
    },
  },
};
</script>

<style scoped>
.cinfobox {
  border: 1px solid #e3e3e3;
  padding: 10px;
  background-color: #f5f5f5;
  height: 88px;
  border-radius: 5px;
}
.cinfobox p:first-child {
  font-weight: 600;
}
.actionlist .v-list-item {
  cursor: pointer;
}
.v-list-item:hover {
  background-color: #ccc;
}
</style>
