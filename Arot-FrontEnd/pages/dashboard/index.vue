<template>
  <v-container id="dashboard" fluid tag="section" grid-list-xl>
    <v-row>
      <v-col class="text-right">
        <v-btn-toggle v-model="reportfor" borderless>
          <v-btn value="daily"> Daily </v-btn>
          <v-btn value="weekly"> Weekly </v-btn>
          <v-btn value="monthly"> Monthly </v-btn>
          <v-btn value="yearly"> Yearly </v-btn>
        </v-btn-toggle>
      </v-col>
    </v-row>
    <v-layout row class="dashinfo">
      <v-flex xs6 sm4 md3 xl2 class="lg5-custom">
        <v-skeleton-loader
          v-if="isLoading"
          class="mx-auto"
          type="table-heading,divider,article"
        ></v-skeleton-loader>
        <v-card
          v-else
          class="pa-4 gradient-45deg-light-blue-cyan gradient-shadow"
        >
          <v-row align="center" justify="center">
            <v-col cols="6" md="4" sm="6">
              <v-icon class="background-round" color="white"
                >mdi-cash-multiple</v-icon
              >
            </v-col>
            <v-col cols="6" md="8" sm="6" style="float: right">
              <p>{{ $t("total_income") }}</p>
              <h5>{{ dashboardinfo.totalcollection }}</h5>
            </v-col>
          </v-row>
        </v-card>
      </v-flex>

      <v-flex xs6 sm4 md3 xl2 class="lg5-custom">
        <v-skeleton-loader
          v-if="isLoading"
          class="mx-auto"
          type="table-heading,divider,article"
        ></v-skeleton-loader>
        <v-card v-else class="pa-4 gradient-45deg-green-teal gradient-shadow">
          <v-row align="center" justify="center">
            <v-col cols="6" md="4" sm="6">
              <v-icon class="background-round" color="white"
                >mdi-sort-descending</v-icon
              >
            </v-col>
            <v-col cols="6" md="8" sm="6" style="float: right">
              <p>{{ $t("total_profit") }}</p>
              <h5>{{ dashboardinfo.totalcollection-dashboardinfo.totalExpense}}</h5>
            </v-col>
          </v-row>
        </v-card>
      </v-flex>

      <v-flex xs6 sm4 md3 xl2 class="lg5-custom">
        <v-skeleton-loader
          v-if="isLoading"
          class="mx-auto"
          type="table-heading,divider,article"
        ></v-skeleton-loader>
        <v-card v-else class="pa-4 gradient-45deg-red-pink gradient-shadow">
          <v-row align="center" justify="center">
            <v-col cols="6" md="4" sm="6">
              <v-icon class="background-round" color="white"
                >mdi-sort-ascending</v-icon
              >
            </v-col>
            <v-col cols="6" md="8" sm="6" style="float: right">
              <p>{{ $t("total_spent") }}</p>
              <h5>{{ dashboardinfo.totalExpense }}</h5>
            </v-col>
          </v-row>
        </v-card>
      </v-flex>

      <v-flex xs6 sm4 md3 xl2 class="lg5-custom">
        <v-skeleton-loader
          v-if="isLoading"
          class="mx-auto"
          type="table-heading,divider,article"
        ></v-skeleton-loader>
        <v-card v-else class="pa-4 gradient-45deg-violet-pink gradient-shadow">
          <v-row align="center" justify="center">
            <v-col cols="6" md="4" sm="6">
              <v-icon class="background-round" color="white">
                mdi-account-multiple</v-icon
              >
            </v-col>
            <v-col cols="6" md="8" sm="6" style="float: right">
              <p>{{ $t("total_client") }}</p>
              <h5>{{ dashboardinfo.totalclient }}</h5>
            </v-col>
          </v-row>
        </v-card>
      </v-flex>
      <v-flex xs6 sm4 md3 xl2 class="lg5-custom">
        <v-skeleton-loader
          v-if="isLoading"
          class="mx-auto"
          type="table-heading,divider,article"
        ></v-skeleton-loader>
        <v-card v-else class="pa-4 gradient-45deg-amber-amber gradient-shadow">
          <v-row align="center" justify="center">
            <v-col cols="6" md="4" sm="6">
              <v-icon class="background-round" color="white">
                mdi-account-multiple</v-icon
              >
            </v-col>
            <v-col cols="6" md="8" sm="6" style="float: right">
              <p>{{ $t("total_customer") }}</p>
              <h5>{{ dashboardinfo.totalcustomer }}</h5>
            </v-col>
          </v-row>
        </v-card>
      </v-flex>
    </v-layout>
    <v-row class="pb-15">
      <v-col cols="12" md="7" xl="8">
        <v-skeleton-loader
          v-if="isLoading"
          class="mt-5"
          type="table-heading,divider,article"
        ></v-skeleton-loader>
        <base-material-card color="primary" v-else>
          <template v-slot:heading>
            <div class="body-3 font-weight-light">
              {{ $t("leatest_transactions") }}
            </div>
          </template>
          <v-card-text style="padding: 0px">
            <apexchart
              type="line"
              height="350"
              :options="lineOptions"
              :series="lineseries"
            ></apexchart>
          </v-card-text>
        </base-material-card>
      </v-col>
      <v-col cols="12" md="5" xl="4">
        <v-skeleton-loader
          v-if="isLoading"
          class="mt-5"
          type="table-heading,divider,article"
        ></v-skeleton-loader>
        <base-material-card color="info" v-else>
          <template v-slot:heading>
            <div class="body-3 font-weight-light">
              {{ $t("commissions") }}
            </div>
          </template>
          <v-card-text
            style="padding: 37px 10px"
            v-if="dashboardinfo.commissions"
          >
            <v-list style="display: inline-flex">
              <v-list-item>
                <v-list-item-title>
                  {{ $t("arot_commission") }}
                  <p class="arot-commission mt-2">
                    {{ dashboardinfo.commissions.arot_commission }}
                    {{ $t("amount") }}
                  </p>
                </v-list-item-title>
                <v-list-item-action>
                  <!-- <v-progress-circular
                      :rotate="-90"
                      :size="100"
                      :width="10"
                      :value="arot_percentage"
                      color="primary"
                    >
                      {{ arot_percentage }}
                    </v-progress-circular> -->
                </v-list-item-action>
              </v-list-item>

              <v-list-item>
                <v-list-item-title>
                  {{ $t("market_commission") }}
                  <p class="market-commission mt-2">
                    {{ dashboardinfo.commissions.bazar_commission }}
                    {{ $t("amount") }}
                  </p>
                </v-list-item-title>
                <!-- <v-list-item-action>
                    <v-progress-circular
                      :rotate="-90"
                      :size="100"
                      :width="10"
                      :value="bazar_percentage"
                      color="success"
                    >
                      {{ bazar_percentage }}
                    </v-progress-circular>
                  </v-list-item-action> -->
              </v-list-item>
            </v-list>
            <div id="chart" v-if="piedata.length > 0">
              <apexchart
                type="pie"
                width="380"
                :options="chartOptions"
                :series="piedata"
              ></apexchart>
            </div>
          </v-card-text>
        </base-material-card>
      </v-col>

      <!-- <v-col cols="12" md="5">
        <base-material-card color="accent">
          <template v-slot:heading>
            <div class="body-3 font-weight-light">
              {{ $t("commissions") }}
            </div>
          </template>
          <v-card-text>
            <div id="chart" v-if="piedata.length>0">
              <apexchart
                type="pie"
                width="380"
                :options="chartOptions"
                :series="piedata"
              ></apexchart>
            </div>
          </v-card-text>
        </base-material-card>
      </v-col> -->

      <v-col cols="12" md="6" xl="4">
        <v-skeleton-loader
          v-if="isLoading"
          class="mx-auto"
          type="table-heading,divider,table-tbody"
        ></v-skeleton-loader>
        <base-material-card color="primary" v-else>
          <template v-slot:heading>
            <div class="body-3 font-weight-light">
              {{ $t("cash_payment") }}
            </div>
          </template>
          <v-card-text>
            <v-data-table
              :headers="paymentheaders"
              :items="dashboardinfo.latest_payment"
            />
          </v-card-text>
        </base-material-card>
      </v-col>

      <v-col cols="12" md="6" xl="4">
        <v-skeleton-loader
          v-if="isLoading"
          class="mx-auto"
          type="table-heading,divider,article"
        ></v-skeleton-loader>
        <base-material-card class="px-5 py-3" color="info" v-else>
          <template v-slot:heading>
            <div class="body-3 font-weight-thin">
              {{ $t("popular_fish") }}
            </div>
          </template>

          <v-list>
            <div class="d-flex justify-space-between" style="padding: 0px 16px">
              <p class="body-2 grey--text">{{ $t("fish_name") }}</p>
              <p class="body-2 grey--text">{{ $t("sell_percentage") }}</p>
            </div>
            <v-divider />
            <v-list-item-group>
              <v-list-item
                v-for="(item, i) in dashboardinfo.popular_fish"
                :key="i"
              >
                <v-list-item-avatar>
                  <img :src="item.image" alt="" />
                </v-list-item-avatar>
                <v-list-item-content>
                  <v-list-item-title v-text="item.name"></v-list-item-title>
                  <v-list-item-subtitle
                    v-text="item.total_amount"
                  ></v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action style="display: inline !important">
                  <v-list-item-action-text
                    class="black--text"
                    v-text="getPercentage(item.total_amount)"
                    style="font-size: 16px"
                  ></v-list-item-action-text>
                  <v-icon class="green lighten-1" dark> mdi-arrow-up </v-icon>
                </v-list-item-action>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </base-material-card>
      </v-col>
      <v-col cols="12" md="6" xl="4">
        <v-skeleton-loader
          v-if="isLoading"
          class="mx-auto"
          type="table-heading,divider,article"
        ></v-skeleton-loader>
        <base-material-card class="px-5 py-3" color="primary" v-else>
          <template v-slot:heading>
            <div class="body-3 font-weight-thin">
              {{ $t("regular_customer") }}
            </div>
          </template>

          <v-list>
            <div class="d-flex justify-space-between" style="padding: 0px 16px">
              <p class="body-2 grey--text">{{ $t("customer_name") }}</p>
              <p class="body-2 grey--text">{{ $t("transaction_amount") }}</p>
            </div>
            <v-divider />
            <v-list-item-group>
              <v-list-item
                v-for="(item, i) in dashboardinfo.regular_customers"
                :key="i"
              >
                <v-list-item-avatar>
                  <img :src="item.customer_img" alt="" />
                </v-list-item-avatar>
                <v-list-item-content>
                  <v-list-item-title v-text="item.name"></v-list-item-title>
                </v-list-item-content>
                <v-list-item-action>
                  <v-list-item-action-text
                    style="font-size: 16px"
                    class="black--text"
                    v-text="item.total_amount"
                  ></v-list-item-action-text>
                </v-list-item-action>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </base-material-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "AppDashboard",
  middleware: "auth",
  head() {
    return {
      // title: "Arothdar" + "|" + this.headline,
      title: "Dashboard",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Home page description",
        },
        {
          hid: "keyword",
          name: "keywords",
          content: "Home, page, description,",
        },
      ],
    };
  },

  data() {
    return {
      isLoading: false,
      days: [],
      pieCom: [],
      chartTitle: "",
      chartOptions: {
        chart: {
          width: 280,
          type: "pie",
        },
        noData: {
          text: "Loading...",
        },
        labels: ["Arot Commission", "Bazar Commission"],
        responsive: [
          {
            breakpoint: 480,
            options: {
              chart: {
                width: 200,
              },
              legend: {
                position: "bottom",
              },
            },
          },
        ],
      },
      dashboardinfo: {},
      reportfor: "daily",
      ls: [],
      paymentheaders: [
        {
          sortable: false,
          text: this.$t("payment_type"),
          value: "select_mode",
        },
        // {
        //   sortable: false,
        //   text: this.$t("payment_via"),
        //   value: "bank_name",
        // },
        {
          sortable: false,
          text: this.$t("amount"),
          value: "payment_amount",
        },
        {
          sortable: false,
          text: this.$t("date"),
          value: "created_at",
        },
      ],
    };
  },
  mounted() {
    //this.$store.commit("title/SET_TITLE", this.$t("dashboard"));
    this.getDashboardData();
  },
  computed: {
    lineseries() {
      return this.ls;
    },
    arot_percentage() {
      let totalcom =
        this.dashboardinfo.commissions.arot_commission +
        this.dashboardinfo.commissions.bazar_commission;
      if (totalcom > 0) {
        return (
          (
            (this.dashboardinfo.commissions.arot_commission / totalcom) *
            100
          ).toFixed(2) + " %"
        );
      } else {
        return 0 + " %";
      }
    },
    bazar_percentage() {
      let totalcom =
        this.dashboardinfo.commissions.arot_commission +
        this.dashboardinfo.commissions.bazar_commission;
      if (totalcom > 0) {
        return (
          (
            (this.dashboardinfo.commissions.bazar_commission / totalcom) *
            100
          ).toFixed(2) + " %"
        );
      } else {
        return 0 + " %";
      }
    },
    piedata() {
      return this.pieCom;
    },
    lineOptions() {
      return {
        chart: {
          height: 250,
          type: "line",
          zoom: {
            enabled: true,
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
        },
        noData: {
          text: "Loading...",
        },
        title: {
          text: this.chartTitle,
        },
        xaxis: {
          categories: this.days,
        },
      };
    },
    headline() {
      return this.$store.getters["title/pagetitle"];
    },
  },
  methods: {
    getPercentage(amount) {
      const sum = this.dashboardinfo.popular_fish
        .map((item) => item.total_amount)
        .reduce((prev, curr) => prev + curr, 0);
      return ((amount / sum) * 100).toFixed(2) + "%";
    },
    getDashboardData() {
      this.isLoading = true;
      this.$axios
        .get("/dashboard-data?reportfor=" + this.reportfor)
        .then((res) => {
          const data = res.data.data;
          this.chartTitle = data.title;
          this.dashboardinfo = data;
          this.days = data.days;
          this.ls.push(data.cash_payment);
          this.ls.push(data.due_payment);
          this.ls.push(data.advance_payment);
          let com = data.commissions;
          this.pieCom = Object.keys(com).map((key) => com[key]);
          this.isLoading = false;
        });
    },
    complete(index) {
      this.list[index] = !this.list[index];
    },
  },
  watch: {
    reportfor(val) {
      this.$axios.get("/dashboard-data?reportfor=" + val).then((res) => {
        const data = res.data.data;
        this.chartTitle = data.title;
        this.dashboardinfo = data;
        this.days = data.days;
        (this.ls = []), this.ls.push(data.cash_payment);
        this.ls.push(data.due_payment);
        this.ls.push(data.advance_payment);
        let com = data.commissions;
        this.pieCom = Object.keys(com).map((key) => com[key]);
      });
    },
  },
};
</script>
<style lang="scss" scoped>
@media (min-width: 1264px) and (max-width: 2000px) {
  .flex.lg5-custom {
    width: 20%;
    max-width: 20%;
    flex-basis: 20%;
  }
}
.v-application .title {
  line-height: 1rem !important;
}
@media (min-width: 950px) {
  .dash-card-margin {
    margin-top: -100px;
  }
}
@media (min-width: 1280px) {
  .dash-card-margin {
    margin-top: -100px;
  }
  .arot-commission {
    font-size: 1.5rem !important;
    color: #303f9f;
  }
  .market-commission {
    font-size: 1.5rem !important;
    color: #388e3c;
  }
}
.arot-commission {
  font-size: 2rem;
  color: #303f9f;
}
.market-commission {
  font-size: 2rem;
  color: #388e3c;
}
.v-btn--active {
  background: #4caf50 !important;
}
.v-list-item {
  padding: 0 5px;
}
.v-icon.v-icon
{
  font-size: 18px;
}
// .apexcharts-legend
// {
//   right: 36px !important;
// }
</style>
