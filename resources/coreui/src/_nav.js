export default {
  items: [
    {
      title: true,
      name: "User Management",
      class: "",
      wrapper: {
        element: "",
        attributes: {}
      },
      auth: {
        roles: ["SuperAdmin"]
      }
    },
    {
      name: "Users",
      url: "/users",
      icon: "fa fa-users",
      auth: {
        roles: ["SuperAdmin"]
      }
    }
  ]
};
