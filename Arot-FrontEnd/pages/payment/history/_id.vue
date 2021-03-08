<template>
  <v-container fluid grid-list-xl class="mt-2">
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
    <clear-due
      :dueamount="totalDue"
      :client="client"
      :payments="history"
      :clientId="clientId"
      @paymentRefresh="clientPayments()"
    />
    <v-row>
      <v-col cols="12" md="4" xl="3" sm="12">
        <v-card>
          <v-card-title>
            {{ $t("client_name") }} : {{ client.name }}
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="6" sm="12">
                <h4>
                  {{ $t("due") }}
                </h4>
                <p class="body-1 text--primary">
                  {{ Math.round(totalDue) }} {{ $t("amount") }}
                </p>
              </v-col>
              <v-col cols="12" md="6" sm="12">
                <h4>
                  {{ $t("advance_amount") }}
                </h4>
                <p class="body-1 text--primary">
                  {{ Math.round(client.advance_ude) }} {{ $t("amount") }}
                </p>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions class="pt-0">
            <v-btn dark color="primary" @click="addPayment">
              {{ $t("add_payment") }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="12">
        <v-card>
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
          <v-data-table :headers="headers" :items="history" :search="search">
            <template v-slot:item.payment_status="{ item }">
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
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import clearDue from "@/components/payment/history/ClearDuePayment";
export default {
  name: "collectionHistory",
  head: {
    title: "",
  },
  components: { clearDue },
  data() {
    return {
      modal: false,
      search: "",
      clientId: this.$route.params.id,
      direction: "top right",
      alert: false,
      message: "",
    };
  },
  computed: {
    parsedDirection() {
      return this.direction.split(" ");
    },
    headers() {
      return [
        {
          text: this.$t("invoice_no"),
          value: "invoice_no",
        },
        {
          text: this.$t("client_name"),
          value: "client_name",
        },

        {
          text: this.$t("commission"),
          value: "commission",
        },
        {
          text: this.$t("payment_status"),
          value: "payment_status",
        },
        {
          text: this.$t("total"),
          value: "total",
        },
        {
          text: this.$t("total_paid"),
          value: "total_paid",
        },
        {
          text: this.$t("due"),
          value: "payment_due",
        },
      ];
    },
  },
  async asyncData({ params, $axios }) {
    const { data } = await $axios.get("history/payment?client_id=" + params.id);
    return {
      totalDue: data.record.reduce((sum, obj) => sum + obj.payment_due, 0),
      history: data.record,
      client: data.client,
    };
  },
  mounted() {},
  methods: {
    addPayment() {
      this.$store.commit("SET_MODAL", true);
    },
    clientPayments() {
      this.$axios
        .get("history/payment?client_id=" + this.clientId)
        .then((res) => {
          this.alert = true;
          this.message = "Payment saved Successfully";
          this.client=res.data.client
          this.history = res.data.record;
          this.totalDue = res.data.record.reduce(
            (sum, obj) => sum + obj.payment_due,
            0
          );
        });
    },
  },
};
</script>

<style>
</style>
