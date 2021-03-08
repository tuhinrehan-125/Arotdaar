<template>
  <v-container fluid grid-list-xl class="mt-5">
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
    <v-row>
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
    </v-row>
    <v-row class="poswrapper">
      <v-col cols="12" sm="6" md="8" xl="8">
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="3" md="6" xl="6">
                <v-autocomplete
                  v-model="selectedProduct"
                  :items="products"
                  :loading="prductLoading"
                  :search-input.sync="productSearch"
                  solo
                  clearable
                  hide-no-data
                  hide-selected
                  item-text="name"
                  item-value="id"
                  label="Type To Search Product"
                  placeholder="Type To Search Product"
                  return-object
                ></v-autocomplete>
              </v-col>
              <v-col cols="12" sm="3" md="6" xl="6">
                <v-select
                  :items="clients"
                  label="Select client name"
                  solo
                  required
                  ref="client"
                  v-model="client_id"
                  item-text="name"
                  item-value="id"
                ></v-select>
              </v-col>
            </v-row>
            <v-data-table
              class="postable"
              :headers="headers"
              :items="cartItems"
              fixed-header
              height="400px"
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
                    style="width: 70px"
                    @change="qtyMethodChange($event, cartItems.indexOf(item))"
                    :value="item.qtymethod"
                    :items="units"
                    :label="$t('unit')"
                    solo
                    item-text="name"
                    item-value="name"
                  ></v-select>
                  <v-text-field
                    style="margin-left: 5px; width: 100px"
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

              <template v-slot:item.status="{ item }" style="margin-left: 20%">
                <v-radio-group
                  @change="paymentMethodChange($event, cartItems.indexOf(item))"
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
          </v-card-text>
        </v-card>

        <v-spacer />

        <v-card class="mx-auto" max-width="500">
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
                  <v-list-item-title>{{ totalPrice }}</v-list-item-title>
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
                  <v-list-item-title>{{ advancetaken }}</v-list-item-title>
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
                  <v-list-item-title>{{ grandTotal }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4" xl="4">
        <v-row>
          <v-col cols="12" md="12">
            <v-card>
              <v-tabs class="pospro" dark background-color="primary">
                <v-tabs-slider
                  color="light-blue accent-4"
                  elevation="2"
                ></v-tabs-slider>

                <v-tab v-for="(cat, i) in items" :key="i" :href="'#tab-' + i">
                  {{ cat.category }}
                </v-tab>

                <v-tab-item
                  v-for="(amc, index) in items"
                  :key="index"
                  :value="'tab-' + index"
                >
                  <v-container fluid>
                    <v-row>
                      <v-col
                        v-for="(pro, m) in amc.products"
                        :key="m"
                        cols="4"
                        md="3"
                        xl="2"
                      >
                        <v-item v-slot="{ active, toggle }">
                          <v-card
                            :color="active ? 'primary' : ''"
                            class="d-flex align-center"
                            light
                            height="100"
                            width="140"
                            @click="addtoCart(pro)"
                          >
                            <v-img :src="pro.image"></v-img>
                          </v-card>
                        </v-item>
                        <p class="body-2">{{ pro.name }}</p>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-tab-item>
              </v-tabs>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
      <v-col>
        <v-btn tile color="success" class="float-right" @click="makeSell">
          <v-icon left> mdi-cart-arrow-up </v-icon>
          {{ $t("make_sale") }}
        </v-btn>
        <v-btn tile color="primary" class="float-right" @click="makeInvoice">
          <v-icon left> mdi-file-document </v-icon>
          {{ $t("make_invoice") }}
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Vue from "vue";
import Invoice from "@/components/print/PurchaseInvoice";
import VueHtmlToPaper from "vue-html-to-paper";
const options = {
  name: "_blank",
  specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
  styles: [
    "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css",
  ],
};
import { mapState, mapMutations } from "vuex";
Vue.use(VueHtmlToPaper, options);

export default {
  name: "pos",
  middleware: "auth",
  head: {
    title: "POS",
  },
  components: { Invoice },
  data() {
    return {
      arot: {},
      units: [{ name: "KG" }, { name: "Thika" }],
      advancetaken: 0.0,
      purchasecommission: 0,
      advance_payout: 0.0,
      qty: 1,
      amount: "",
      type: "success",
      active: "",
      tab: "",
      message: "",
      alert: false,
      client_id: null,
      form: {},
      items: [],
      prductLoading: false,
      selectedProduct: null,
      selectedCustomer: null,
      selectedClient: null,
      productSearch: null,
      clientSearch: null,
      products: [],
      customerLoading: false,
      clientLoading: false,
      customerSearch: null,
      clientSearch: null,
      direction: "top right",
      customers: [],
      clients: [],
      form: {},
      invoice_no: "",
    };
  },
  computed: {
    user() {
      return this.$auth.user.data;
    },
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("item_name"),
          value: "product",
          align: "left",
          width: "80px",
        },
        {
          sortable: false,
          text: this.$t("price") + " (" + this.$t("in_mon") + ")",
          value: "price",
          align: "center",
          width: "80px",
        },
        {
          sortable: false,
          text: this.$t("quantity"),
          value: "qty",
          align: "center",
          width: "100px",
        },
        {
          sortable: false,
          text: this.$t("total"),
          value: "total",
          align: "center",
          width: "10px",
        },
        {
          sortable: false,
          text: this.$t("customer_name"),
          value: "customer_name",
          align: "center",
          width: "100px",
        },
        {
          sortable: false,
          text: this.$t("status"),
          align: "center",
          value: "status",
          width: "120px",
        },
        {
          sortable: false,
          text: this.$t("action"),
          value: "actions",
          width: "40px",
        },
      ];
    },
    parsedDirection() {
      return this.direction.split(" ");
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
    this.setDrawer(false);
  },
  mounted() {
    this.getPosProducts();
    this.getCustomers();
    this.getClients();
    this.getSettings();
  },

  methods: {
    ...mapMutations({
      setDrawer: "SET_DRAWER",
    }),

    makeInvoice() {
      if (this.client_id == null) {
        this.type = "error";
        this.alert = true;
        this.message = { msg: ["Please Select a client"] };
        return;
      }
      if (this.cartItems.length<1) {
        this.type = "error";
        this.alert = true;
        this.message = { msg: ["Please Select Product"] };
        return;
      }
      if (this.grandTotal<1) {
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
          this.type = "success";
          this.alert = true;
          this.message = { msg: ["Products saved to invoice"] };
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
      if (this.cartItems.length<1) {
        this.type = "error";
        this.alert = true;
        this.message = { msg: ["Please Select Product"] };
        return;
      }
      if (this.grandTotal<1) {
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
        })
        .then((res) => {
          this.type = "success";
          this.alert = true;
          this.message = { msg: ["Products added in sell"] };
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
    async getCustomers() {
      await this.$axios.get("/customer").then((response) => {
        this.customers = response.data;
      });
    },
    async getClients() {
      await this.$axios.get("/client").then((response) => {
        this.clients = response.data;
      });
    },
    getPosProducts() {
      this.$axios.get("/pos-prodcuts").then((res) => {
        this.items = res.data.data;
      });
    },
    async getSettings() {
      await this.$axios.get("/settings").then((res) => {
        this.invoice_no = res.data.invoice_no;
        this.arot = res.data.setting;
      });
    },
    editItem(item) {},
    removeItem(item, index) {
      this.$store.dispatch("cart/removeCartItem", {
        product: item,
        index: index,
      });
      this.type = "success";
      this.alert = true;
      this.message = { msg: ["Product Removed"] };
    },

    addtoCart(item) {
      this.$store.dispatch("cart/addToCart", {
        product: item.name,
        product_id: item.id,
        price: "",
        quantity: "",
        customer_id: "",
        customer_name: "",
        ptype: "Bokeya",
        qtymethod: "KG",
      });
      this.type = "success";
      this.alert = true;
      this.message = { msg: ["Product added into list"] };
    },
  },
  watch: {
    purchasecommission(val) {
      let commission = val;
      this.$store.commit("cart/SET_COMMISSION", commission);
    },
    selectedCustomer(val) {
      this.purchasecommission = val.commission;
    },
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
      this.type = "success";
      this.alert = true;
      this.message = { msg: ["Product added into list"] };
    },
    productSearch(val) {
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
    },
    clientSearch(val) {
      this.clientLoading = true;
      this.$axios
        .get("/client-search?name=" + val)
        .then((res) => {
          this.clients = res.data;
          this.clientLoading = false;
        })
        .catch((err) => {
          console.log(err);
          this.clientLoading = false;
        });
    },
    customerSearch(val) {
      this.customerLoading = true;
      this.$axios
        .get("/customer-search?name=" + val)
        .then((res) => {
          this.customers = res.data;
          console.log(res.data.commission);
          this.customerLoading = false;
        })
        .catch((err) => {
          console.log(err);
          this.customerLoading = false;
        });
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
.poswrapper {
  margin-top: -40px;
}

.pos-table {
  padding: 0px;
}
.number-input--inline {
  width: 105px;
}
#printMe {
  display: none;
}
.poswrapper .v-text-field.v-text-field--solo .v-input__control {
  min-height: 10px;
}
.poswrapper .v-label {
  font-size: 15px;
}
.v-data-table > .v-data-table__wrapper > table > tbody > tr > td {
  padding: 0 8px;
}
.v-data-table .v-input--radio-group__input .v-icon {
  font-size: 18px;
}
.postable .v-input--selection-controls__ripple {
  border-radius: 50%;
  cursor: pointer;
  height: 20px;
  position: absolute;
  transition: inherit;
  width: 20px;
  left: -5px;
  top: calc(50% - 17px);
  margin: 7px;
}

.light::-webkit-scrollbar {
  width: 10px;
}
.pospro .v-item-group {
  max-height: 506px;
  overflow: auto;
}
</style>
