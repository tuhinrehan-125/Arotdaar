<template>
  <v-container fluid grid-list-xl class="mt-5">
    <v-row justify="center">
      <!-- <add-payment :paymentinfo="paymentinfo" @payemntRefresh="getPayments()" />
      <show-payment :data="paymentData" /> -->
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
    <!-- <v-row>
      <v-col>
        <v-btn tile color="indigo" class="float-right" @click="addPaymentModal">
          <v-icon left> mdi-plus </v-icon>
          {{ $t("add_payment") }}
        </v-btn>
      </v-col>
    </v-row> -->
    <v-row>
      <v-col cols="12" md="12">
        <v-card v-if="isLoading">
          <v-skeleton-loader class="mx-auto" type="table"></v-skeleton-loader>
        </v-card>
        <v-card v-else>
          <v-card-title>
            {{ $t("payment_list") }}
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
            <v-data-table :headers="headers" :items="payments" :search="search">
               <template v-slot:item.client_name="{ item }" v-slot:item.id="{item}">
                  <NuxtLink :to="{name: 'payment-history-id',params: { id: item.id }}">{{item.client_name}}</NuxtLink>
              </template>
              <!-- <template v-slot:item.payment_status="{ item }">
                <v-chip
                  color="success"
                  label
                  v-if="item.payment_status == 'Paid'"
                >
                  {{ $t("paid") }}</v-chip
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
                      {{ $t("action") }}
                      <v-icon right dark> mdi-menu-down </v-icon>
                    </v-btn>
                  </template>
                  <v-list class="actionlist">
                    <v-list-item v-if="item.payment_due > 0">
                      <v-list-item-title @click="addPayment(item)">{{
                        $t("add_payment")
                      }}</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-title @click="viewPayment(item)">{{
                        $t("view_payment")
                      }}</v-list-item-title>
                    </v-list-item>
                    <v-list-item
                      :to="{
                        name: 'payment-history-id',
                        params: { id: item.client_id },
                      }"
                    >
                      <v-list-item-title> {{ $t("payment_history") }}</v-list-item-title>
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
// import addPayment from "@/components/payment/addPayment";
// import showPayment from "@/components/payment/showPayment";
export default {
  name: "Payments",
  middleware: "auth",
  head: {
    title: "Payments",
  },
  components: { },
  data() {
    return {
      search: "",
      isLoading: false,
      confirmation: false,
      update: false,
      paymentData: "",
      headline: this.$t("add_payment"),
      alert: false,
      valid: true,
      message: "",
      nameRules: [(v) => !!v || "Name is required"],
      dialog: false,
      subcatid: "",
      direction: "top right",
      categories: [],
      paymentinfo: {},
      payments: [],
    };
  },
  computed: {
    headers() {
      return [
        {
          text: this.$t("client_name"),
          value: "client_name",
        },
        {
          text: this.$t("phone_no"),
          value: "phone_no",
        },
        {
          text: this.$t("sell"),
          value: "sell",
        },
        {
          text: this.$t("total_paid"),
          value: "paid",
        },
        {
          text: this.$t("advance_amount"),
          value: "advance_due",
        },
        {
          text: this.$t("due"),
          value: "due",
        },
        // {
        //   text: this.$t("action"),
        //   value: "actions",
        // },
      ];
    },
    parsedDirection() {
      return this.direction.split(" ");
    },
    isOpened() {
      return this.$store.getters.modal;
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getPayments();
  },
  methods: {
    async getPayments() {
      this.isLoading = true;
      await this.$axios.get("/payment").then((response) => {
        this.payments = response.data;
        this.isLoading = false;
      });
    },
    addPayment(item) {
      this.paymentinfo = item;
      this.$store.commit("SET_MODAL", true);
    },
    addPaymentModal() {
      this.$store.commit("SET_MODAL", true);
    },
    viewPayment(item) {
      this.paymentData = item;
      this.$store.commit("SET_VIEW_MODAL", true);
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
