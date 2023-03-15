// Setup Block
const data = {
  labels: ["Delivered Gallons", "On-Align", "Failed Gallons"],
  datasets: [
    {
      label: "Gallons Delivered",
      data: [300, 50, 80],
      backgroundColor: [
        "rgb(255, 99, 132)",
        "rgb(54, 162, 235)",
        "rgb(255, 205, 86)",
      ],
      // borderColor: [
      //   'rgba(255, 99, 132, 1)',
      //   'rgba(54, 162, 235, 1)',
      //   'rgba(255, 206, 86, 1)',
      //   'rgba(75, 192, 192, 1)',
      //   'rgba(153, 102, 255, 1)',
      //   'rgba(255, 159, 64, 1)'
      // ],
      // borderWidth: 1
      hoverOffset: 4,
    },
  ],
};

// Options Block
const options = {
  // plugins: {
  //   legend: {
  //     display: false
  //   }
  // }
};

// Config Block
const config = {
  type: "pie",
  data,
  options,
};

// Render Block
const myChart = new Chart(document.getElementById("myChart"), config);
