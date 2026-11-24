import api from "../api/axios";

export const getAuctions = (params = {}) => {
  return api.get("/auctions", { params });
};