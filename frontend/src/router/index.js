import { createRouter, createWebHistory } from "vue-router";

import Home from "../views/Home.vue";
import About from "../views/About.vue";
import Products from "../views/Products.vue";
import Auctions from "../views/Auctions.vue";
import Contact from "../views/Contact.vue";
import AuctionDetails from "../views/AuctionDetails.vue";
import Login from "../views/Login.vue";

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/about",
    name: "About",
    component: About,
  },
  {
    path: "/products",
    name: "Products",
    component: Products,
  },
  {
    path: "/auctions",
    name: "Auctions",
    component: Auctions,
  },
  {
    path: "/auctions/:id",
    name: "auction.details",
    component: AuctionDetails,
  },
  {
    path: "/contact",
    name: "Contact",
    component: Contact,
  },
  {
    path: "/login",
    name: "Login",
    component: () => Login,
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;