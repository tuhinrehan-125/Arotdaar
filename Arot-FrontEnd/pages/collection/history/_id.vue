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
      :collection="collection"
      :customerId="customerId"
      @collectionRefresh="customerCollections()"
    />
    <v-row>
       <v-col cols="12" md="4" xl="3" sm="12">
        <v-card>
          <v-card-title>
             {{ $t("customer_name") }} : {{ customer.name }}
          </v-card-title>
          <v-card-text>
            <h4>
              {{ $t("due")  }}
            </h4>
            <p class="body-1 text--primary">
              {{ Math.round(totalDue) }} {{ $t("amount") }}
            </p>
          </v-card-text>
          <v-card-actions class="pt-0">
            <v-btn dark color="primary" @click="addCollection">
              {{ $t("add_collection") }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="12">
        <v-card>
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
          <v-data-table :headers="headers" :items="collection" :search="search">
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
import clearDue from "@/components/collection/ClearDue";
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
      customerId: this.$route.params.id,
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
          sortable: false,
          text: this.$t("invoice_no"),
          value: "invoice_no",
        },
        {
          sortable: false,
          text: this.$t("product"),
          value: "product",
        },
        {
          sortable: false,
          text: this.$t("customer_name"),
          value: "customer_name",
        },
        {
          sortable: false,
          text: this.$t("payment_status"),
          value: "payment_status",
        },
        {
          sortable: false,
          text: this.$t("price"),
          value: "product_price",
        },
        {
          sortable: false,
          text: this.$t("total_paid"),
          value: "total_paid",
        },
        {
          sortable: false,
          text: this.$t("due"),
          value: "payment_due",
        },
      ];
    },
  },
  async asyncData({ params, $axios }) {
    const { data } = await $axios.get(
      "history/collection?customer_id=" + params.id
    );
    return {
      totalDue: data.record.reduce((sum, obj) => sum + obj.payment_due, 0),
      collection: data.record,
      customer: data.customer,
    };
  },
  mounted() {},
  methods: {
    addCollection() {
      this.$store.commit("SET_MODAL", true);
    },
    customerCollections() {
      this.$axios
        .get("history/collection?customer_id=" + this.customerId)
        .then((res) => {
          this.alert = true;
          this.message = "Collection saved Successfully";
          this.collection = res.data.record;
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
