<template>
  <v-container>
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
    <div id="printMe">
      <LazyPurchaseInvoice
        :client="selectedClient"
        :invoiceno="invoice_no"
        :products="cartItems"
        :subTotalPrice="subTotal"
        :commission="commission"
        :totalPrice="totalPrice"
        :grandTotal="grandTotal"
        :arot="arot"
        :advance_payout="advance_payout"
      />
    </div>
    <v-row>
      <v-col>
        <v-card class="sales">
          <v-card-title>
            {{ $t("make_sale") }}
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-select
                  :items="clients"
                  label="Select client name"
                  outlined
                  dense
                  required
                  ref="client"
                  v-model="client_id"
                  item-text="name"
                  item-value="id"
                ></v-select>
              </v-col>
              <v-col cols="12" md="8" sm="12" xl="8">
                <v-autocomplete
                  v-model="selectedProduct"
                  :items="products"
                  :loading="prductLoading"
                  :search-input.sync="productSearch"
                  ref="pro"
                  outlined
                  dense
                  clearable
                  hide-no-data
                  item-text="name"
                  item-value="id"
                  placeholder="Type To Search Product"
                  return-object
                ></v-autocomplete>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <h3 class="text-center">Sell Product</h3>
                <v-data-table
                  class="postable"
                  :headers="headers"
                  :items="cartItems"
                  fixed-header
                  :hide-default-footer="true"
                >
                  <template v-slot:item.price="{ item }">
                    <v-text-field
                      solo
                      :value="item.price"
                      size="small"
                      type="number"
                      @keyup="
                        priceChange(
                          $event.target.value,
                          item,
                          cartItems.indexOf(item)
                        )
                      "
                    >
                    </v-text-field>
                  </template>

                  <template v-slot:item.qty="{ item }">
                    <div style="display: inline-flex">
                      <v-select
                        style="width: 100px"
                        @change="
                          qtyMethodChange($event, cartItems.indexOf(item))
                        "
                        :value="item.qtymethod"
                        :items="units"
                        :label="$t('unit')"
                        solo
                        item-text="name"
                        item-value="name"
                      ></v-select>
                      <v-text-field
                        style="margin-left: 5px; width: 120px"
                        v-if="item.qtymethod == 'KG'"
                        solo
                        size="small"
                        :label="$t('quantity')"
                        type="number"
                        :value="item.qty"
                        @change="qtyChange($event, cartItems.indexOf(item))"
                      ></v-text-field>
                    </div>
                  </template>
                  <template v-slot:item.customer_name="{ item }">
                    <v-select
                      :items="customers"
                      label="Select customer name"
                      solo
                      @change="customerChange($event, cartItems.indexOf(item))"
                      item-text="name"
                      item-value="id"
                      style="margin-top: 14px"
                    ></v-select>
                  </template>

                  <template
                    v-slot:item.status="{ item }"
                    style="margin-left: 20%"
                  >
                    <v-radio-group
                      @change="
                        paymentMethodChange($event, cartItems.indexOf(item))
                      "
                      row
                      :value="item.ptype"
                    >
                      <v-radio label="Nogod" value="Nogod"></v-radio>
                      <v-radio label="Bokeya" value="Bokeya"></v-radio>
                    </v-radio-group>
                  </template>

                  <template v-slot:item.actions="{ item }">
                    <v-icon
                      small
                      @click="removeItem(item, cartItems.indexOf(item))"
                    >
                      mdi-delete
                    </v-icon>
                  </template>
                </v-data-table>
              </v-col>
            </v-row>
            <v-row align="center" justify="center">
              <v-col cols="12" md="6" xl="4">
                <v-card>
                  <v-row>
                    <v-col cols="5" md="5" sm="5">
                      <v-list-item class="float-right">
                        <v-list-item-content>
                          <v-list-item-title class="body-2">{{
                            $t("sub_total")
                          }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                    <v-col cols="2" md="2" sm="2">
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>=</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                    <v-col cols="5" md="5" sm="5">
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>{{ subTotal }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                  </v-row>
                  <v-divider></v-divider>
                  <v-row>
                    <v-col cols="5" md="5" sm="5">
                      <v-list-item class="float-right">
                        <v-list-item-content>
                          <v-list-item-title class="body-2">{{
                            $t("commission")
                          }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                    <v-col cols="2" md="2" sm="2">
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>=</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                    <v-col cols="5" md="5" sm="5" class="float-right">
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>
                            <v-text-field
                              v-model="purchasecommission"
                              hide-details
                              single-line
                              outlined
                              dense
                              style="width: 100px"
                              type="number"
                              min="0"
                              append-icon="mdi-percent"
                            />
                          </v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                  </v-row>
                  <v-divider></v-divider>
                  <v-row>
                    <v-col cols="5" md="5" sm="5">
                      <v-list-item class="float-right">
                        <v-list-item-content>
                          <v-list-item-title class="body-2">{{
                            $t("total")
                          }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                    <v-col cols="2" md="2" sm="2">
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>=</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                    <v-col cols="5" md="5" sm="5" class="float-right">
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>{{
                            totalPrice
                          }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                  </v-row>
                  <v-divider></v-divider>
                  <v-row>
                    <v-col cols="5" md="5" sm="5">
                      <v-list-item class="float-right">
                        <v-list-item-content>
                          <v-list-item-title class="body-2">{{
                            $t("dadan")
                          }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                    <v-col cols="2" md="2" sm="2">
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>=</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                    <v-col cols="5" md="5" sm="5" class="float-right">
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>{{
                            advancetaken
                          }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                  </v-row>
                  <v-divider></v-divider>
                  <v-row>
                    <v-col cols="5" md="5" sm="5">
                      <v-list-item class="float-right">
                        <v-list-item-content>
                          <v-list-item-title class="body-2">{{
                            $t("dadan_payout")
                          }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                    <v-col cols="2" md="2" sm="2">
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>=</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                    <v-col cols="5" md="5" sm="5" class="float-right">
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>
                            <v-text-field
                              v-model="advance_payout"
                              hide-details
                              single-line
                              outlined
                              dense
                              style="width: 100px"
                              type="number"
                              min="0"
                            />
                          </v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                  </v-row>
                  <v-divider></v-divider>
                  <v-row>
                    <v-col cols="5" md="5" sm="5">
                      <v-list-item class="float-right">
                        <v-list-item-content>
                          <v-list-item-title class="body-2">{{
                            $t("in_total")
                          }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                    <v-col cols="2" md="2" sm="2">
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>=</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                    <v-col cols="5" md="5" sm="5" class="float-right">
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>{{
                            grandTotal
                          }}</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                  </v-row>
                </v-card>
                <br />
                <v-row style="float: right">
                  <v-col>
                    <v-btn tile color="success" @click="makeSell">
                      <v-icon left> mdi-cart-arrow-up </v-icon>
                      {{ $t("make_sale") }}
                    </v-btn>

                    <v-btn tile color="primary" @click="makeInvoice">
                      <v-icon left> mdi-file-document </v-icon>
                      {{ $t("make_invoice") }}
                    </v-btn>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Vue from "vue";
import VueHtmlToPaper from "vue-html-to-paper";
const options = {
  name: "_blank",
  specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
  styles: [
    "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css",
  ],
};
Vue.use(VueHtmlToPaper, options);
export default {
  name: "sales",
  head: {
    title: "",
  },
  components: {},
  data() {
    return {
      alert:false,
      message: null,
      selectedClient: null,
      isPurchase: false,
      customers: [],
      selectedProduct: null,
      prductLoading: false,
      items: [],
      productSearch: null,
      client_id: "",
      clients: [],
       client_id: null,
      purchasecommission: 0,
      advance_payout: 0.0,
      advancetaken: 0.0,
      products: [],
      invoice_no: "",
      arot: {},
      units: [{ name: "KG" }, { name: "Thika" }],
      direction: "top right",
    };
  },
  computed: {
    user() {
      return this.$auth.user.data;
    },
    parsedDirection() {
      return this.direction.split(" ");
    },
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("item_name"),
          value: "product",
          align: "left",
        },
        {
          sortable: false,
          text: this.$t("price") + " (" + this.$t("in_mon") + ")",
          value: "price",
          align: "center",
        },
        {
          sortable: false,
          text: this.$t("quantity"),
          value: "qty",
          align: "center",
        },
        {
          sortable: false,
          text: this.$t("total"),
          value: "total",
          align: "center",
        },
        {
          sortable: false,
          text: this.$t("customer_name"),
          value: "customer_name",
          align: "center",
        },
        {
          sortable: false,
          text: this.$t("status"),
          align: "center",
          value: "status",
        },
        {
          sortable: false,
          text: this.$t("action"),
          value: "actions",
        },
      ];
    },
    cartItems() {
      let products = this.$store.getters["cart/getCartProducts"];
      return products;
    },
    subTotal() {
      return this.$store.getters["cart/subTotalPrice"];
    },
    commission() {
      return this.$store.getters["cart/commission"];
    },
    advancepayout() {
      return this.$store.getters["cart/advancepayout"];
    },
    totalPrice() {
      return Math.round(this.$store.getters["cart/totalPrice"]);
    },
    grandTotal() {
      let grandtotal = this.$store.getters["cart/grandTotal"];
      return Math.round(grandtotal);
    },
  },
  async asyncData({ params, axios }) {},
  created() {
    this.getClients();
    this.getCustomers();
    this.getSettings();
  },
  methods: {
    async getClients() {
      await this.$axios.get("/client").then((response) => {
        this.clients = response.data;
      });
    },
    async getCustomers() {
      await this.$axios.get("/customer").then((response) => {
        this.customers = response.data;
      });
    },
    async getSettings() {
      await this.$axios.get("/settings").then((res) => {
        this.invoice_no = res.data.invoice_no;
        this.arot = res.data.setting;
      });
    },
    makeInvoice() {
      if (this.client_id == null) {
        this.type = "error";
        this.alert = true;
        this.message = { msg: ["Please Select a client"] };
        return;
      }
      if (this.cartItems.length < 1) {
        this.type = "error";
        this.alert = true;
        this.message = { msg: ["Please Select Product"] };
        return;
      }
      if (this.grandTotal < 1) {
        this.type = "error";
        this.alert = true;
        this.message = { msg: ["Total price can not be 0"] };
        return;
      }
      this.$axios
        .post("/order", {
          products: this.cartItems,
          commission: this.commission,
          advance_payout: this.advancepayout,
          sub_total: this.subTotal,
          total_price: this.totalPrice,
          grand_total: this.grandTotal,
          client: this.client_id,
          type: "invoice",
        })
        .then((res) => {
          this.isPurchase = !this.isPurchase;
          this.type = "success";
          this.alert = true;
          this.message = { msg: ["Products saved into invoice"] };
          this.$htmlToPaper("printMe");
          this.advancetaken = 0;
          this.client_id = "";
          this.advance_payout = 0;
          this.purchasecommission = 0;
          this.$store.commit("cart/SET_CART_PRODUCTS", []);
          this.$store.commit("cart/SET_ADVANCE_PAYOUT", 0);
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
    },
    makeSell() {
      if (this.client_id == null) {
        this.type = "error";
        this.alert = true;
        this.message = { msg: ["Please Select a client"] };
        return;
      }
      if (this.cartItems.length < 1) {
        this.type = "error";
        this.alert = true;
        this.message = { msg: ["Please Select Product"] };
        return;
      }
      if (this.grandTotal < 1) {
        this.type = "error";
        this.alert = true;
        this.message = { msg: ["Total price can not be 0"] };
        return;
      }
      this.isPurchase = !this.isPurchase;
      this.$axios
        .post("/order", {
          products: this.cartItems,
          commission: this.commission,
          advance_payout: this.advancepayout,
          sub_total: this.subTotal,
          total_price: this.totalPrice,
          grand_total: this.grandTotal,
          client: this.client_id,
        })
        .then((res) => {
          this.type = "success";
          this.alert = true;
          this.message = { msg: ["Products saved into invoice"] };
          this.$htmlToPaper("printMe");
          this.advancetaken = 0;
          this.client_id = "";
          this.advance_payout = 0;
          this.purchasecommission = 0;
          this.$store.commit("cart/SET_CART_PRODUCTS", []);
          this.$store.commit("cart/SET_ADVANCE_PAYOUT", 0);
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
    },
    qtyMethodChange(val, index) {
      this.$store.dispatch("cart/updateCartItem", {
        qtymethod: val,
        index: index,
        type: "qtyMchnage",
      });
    },
    paymentMethodChange(val, index) {
      this.$store.dispatch("cart/updateCartItem", {
        ptype: val,
        index: index,
        type: "paymentChange",
      });
    },
    customerChange(val, index) {
      let customerInfo = this.customers.find((item) => {
        return val == item.id;
      });
      this.$store.dispatch("cart/updateCartItem", {
        customer_id: val,
        customer_name: customerInfo.name,
        index: index,
        type: "customerchange",
      });
    },
    qtyChange(val, index) {
      this.$store.dispatch("cart/updateCartItem", {
        qty: val,
        index: index,
        type: "qtychange",
      });
    },
    priceChange(val, item, index) {
      this.$store.dispatch("cart/updateCartItem", {
        product: item,
        price: parseInt(val),
        index: index,
        type: "pricechange",
      });
    },
  },
  watch: {
    selectedProduct(val) {
      this.$store.dispatch("cart/addToCart", {
        product: val.name,
        product_id: val.id,
        price: "",
        quantity: "",
        customer_id: "",
        customer_name: "",
        ptype: "Bokeya",
        qtymethod: "KG",
      });
    },
    productSearch(val) {
      if (val) {
        this.prductLoading = true;
        this.$axios
          .get("/product-search?name=" + val)
          .then((res) => {
            this.products = res.data;
            this.prductLoading = false;
          })
          .catch((err) => {
            console.log(err);
            this.prductLoading = false;
          });
      } else {
      }
    },
    client_id(val) {
      if (val) {
        let client = this.clients.find((item) => {
          return val == item.id;
        });
        this.purchasecommission = client.commission_rate;
        this.selectedClient = client;
        this.advancetaken = client.due;
        this.$store.commit("cart/SET_ADVANCE", this.advancetaken);
      }
    },
    advance_payout(val) {
      this.$store.commit("cart/SET_ADVANCE_PAYOUT", val);
    },
  },
};
</script>

<style>
.sales .v-label {
  font-size: 15px;
}
.sales .v-text-field.v-text-field--solo .v-input__control {
  min-height: 10px;
}
</style>
