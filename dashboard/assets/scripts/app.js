// REDIRECTION FN
const goBack = () => history.back();

const redirectTo = (URL) => {
  const rootURL = "/projects/rrperfumes-v2/dashboard/app";

  window.location = rootURL + URL;
};

// UTILS
const setPageTitle = (title) => {
  document.title = title + " - RR Perfumes Collection";
};

const formatDate = (str) => {
  return moment(new Date(str)).format("MMM DD, YYYY hh:mm A");
};

// HTTP
const httpRequest = async (
  apiEndpoint = "/",
  method,
  payload = {},
  payloadType = "json-payload"
) => {
  console.log({ payloadType });

  axios.defaults.baseURL =
    "http://localhost/projects/rrperfumes-v2/dashboard/core/api";
  axios.defaults.headers.common["Content-Type"] = "application/json";

  let httpResponse = await axios[method](apiEndpoint, payload);

  return httpResponse;
};
