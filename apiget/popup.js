chrome.storage.local.get({ apiData: [] }, function (items) {
  const apiData = items.apiData;
  console.log("Data API dari storage:", apiData);

  const dataList = document.getElementById("data-list");

  apiData.forEach((data) => {
    const listItem = document.createElement("li");
    listItem.textContent = `${data.url}: ${JSON.stringify(data.data)}`;
    dataList.appendChild(listItem);
  });
});
