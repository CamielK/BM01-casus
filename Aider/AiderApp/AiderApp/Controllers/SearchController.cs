using AiderApp.Helpers;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;

namespace AiderApp.Controllers
{
    class SearchController
    {
        public event OutputController.Update UpdateView = null;
        public delegate void Update(JObject streamData);

        public async void SearchLaws(String searchString)
        {
            var requestUrl = "answer/" + searchString;
            AiderBackend api = new AiderBackend();
            api.JsonHandler += parseJson;
            api.GetAiderData(requestUrl);
        }

        private void parseJson(string streamData)
        {
            JObject data = JObject.Parse(streamData);

            if (UpdateView != null)
            { UpdateView(data); }
        }

    }
}
