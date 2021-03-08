<template>
  <v-dialog v-model="isOpened" persistent max-width="600px">
    <v-card>
      <v-toolbar dark color="primary">
        <v-toolbar-title> {{ $t("add_collection") }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn dark text @click="closeModal">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row class="mt-5">
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  :label="$t('amount')"
                  type="number"
                  outlined
                  dense
                  required
                  :rules="dueAmountRules"
                  v-model="amount"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-select
                  :items="payment_from"
                  :label="$t('select_payment_method')"
                  dense
                  outlined
                  required
                  v-model="payment_method"
                ></v-select>
              </v-col>
              <!-- for bank -->
              <template v-if="bybank">
                <v-col cols="6" sm="6" md="6">
                  <p class="body-2">{{ $t("bank_name") }}</p></v-col
                >
                <v-col cols="6" sm="6" md="6">
                  <v-select
                    :items="allbanks"
                    :label="$t('bank_name')"
                    dense
                    outlined
                    :required="!bybank"
                    :rules="bybank ? banknameRules : []"
                    v-model="bank"
                    item-text="bank_name"
                    item-value="id"
                  ></v-select>
                </v-col>
                <v-col cols="6" sm="6" md="6">
                  <p class="body-2">{{ $t("acc_no") }}</p></v-col
                >
                <v-col cols="6" sm="6" md="6">
                  <v-text-field
                    :label="$t('acc_no')"
                    outlined
                    dense
                    disabled
                    :required="!bybank"
                    :rules="bybank ? bankcodeRules : []"
                    v-model="bank_acc"
                  ></v-text-field>
                </v-col>
              </template>

              <!-- for bank -->
              <!-- for bkash -->
              <template v-if="bybkash">
                <v-col cols="6" sm="6" md="6">
                  <p class="body-2">{{ $t("from_bkash") }}</p></v-col
                >
                <v-col cols="6" sm="6" md="6">
                  <v-select
                    :items="allbkash"
                    :label="$t('from_bkash')"
                    dense
                    outlined
                    :required="!bybkash"
                    :rules="bybkash ? frombkashRules : []"
                    v-model="from_bKash"
                    item-text="bkash_number"
                    item-value="bkash_number"
                  ></v-select>
                </v-col>
                <v-col cols="6" sm="6" md="6">
                  <p class="body-2">{{ $t("to_bkash") }}</p></v-col
                >
                <v-col cols="6" sm="6" md="6">
                  <v-text-field
                    :label="$t('to_bkash')"
                    outlined
                    dense
                    :required="!bybkash"
                    :rules="bybkash ? tobkashRules : []"
                    v-model="to_bKash"
                  ></v-text-field>
                </v-col>
              </template>
              <!-- for bkash -->
            </v-row>
          </v-form>
        </v-container>
        <small>{{ $t("indicates_required_field") }}</small>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="closeModal">
          {{ $t("close") }}
        </v-btn>
        <v-btn color="blue darken-1" text @click="submitForm">
          {{ $t("save") }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "ClearDue",
  head: {
    title: "Collection History",
  },
  components: {},
  props: ["dueamount", "collection", "customerId"],
  data() {
    return {
      valid: true,
      dueAmountRules: [
        (v) => !!v || "Amount is required",
        (v) =>
          v <= this.dueamount ||
          "Collection Amount must can not be greater than due amount",
      ],
      frombkashRules: [(v) => !!v || "From bkash number is required"],
      tobkashRules: [(v) => !!v || "To bkash number is required"],
      banknameRules: [(v) => !!v || "Bank name is required"],
      bankcodeRules: [(v) => !!v || "Bank Account is required"],
      banks: [],
      bybkash: false,
      bybank: false,
      amount: "",
      payment_from: ["Bkash", "Bank", "Cash"],
      payment_method: "Cash",
      from_bKash: "",
      to_bKash: "",
      bank_code: "",
      bank: "",
      bank_acc: "",
      allbanks: [],
      allbkash: [],
    };
  },
  computed: {
    dueAmountIds() {
      let collection = this.collection.map((item) => {
        if (item.payment_status == "Due" || item.payment_status == "Partial") {
          return item.id;
        }
      });
      return collection.filter(function (element) {
        return element !== undefined;
      });
    },
    isOpened() {
      return this.$store.getters.modal;
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {},
  methods: {
    closeModal() {
      this.$store.commit("SET_MODAL", false);
    },
    async getAccInfo(type) {
      await this.$axios.get("/account-info?type=" + type).then((response) => {
        if (response.data.type == "Bank") {
          this.allbanks = response.data.data;
        }
        else if (response.data.type == "Bkash") {
          this.allbkash = response.data.data;
        }
      });
    },
    async submitForm() {
      if (this.$refs.form.validate()) {
        await this.$axios
          .post("/bulkcollection", {
            payment_method: this.payment_method,
            from_bKash:this.from_bKash,
            to_bKash:this.to_bKash,
            bank_id:this.bank,
            amount: this.amount,
            id: this.dueAmountIds,
            customer_id: this.customerId,
          })
          .then((response) => {
            this.amount = "";
            this.$refs.form.reset();
            setTimeout(() => this.$store.commit("SET_MODAL", false), 10);
            this.$emit("collectionRefresh");
          });
      }
    },
  },
  watch: {
    bank(val) {
      let bank = this.allbanks.find((item) => {
        return val == item.id;
      });
      this.bank_acc = bank.bank_acc;
    },
    payment_method(val) {
      if (val == "Bank") {
        this.getAccInfo("Bank");
        this.from_bKash = "";
        this.to_bKash = "";
        this.bybkash = false;
        this.bybank = true;
      } else if (val == "Bkash") {
        this.getAccInfo("Bkash");
        this.bank_acc = "";
        this.bank = "";
        this.bybkash = true;
        this.bybank = false;
      } else {
        this.from_bKash = "";
        this.to_bKash = "";
        this.bank_acc = "";
        this.bank = "";
        this.bybkash = false;
        this.bybank = false;
      }
    },
  },
};
</script>

<style>
</style>
