using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace AiderApp.Controllers
{
    class OutputController
    {
        public event Update UpdateView = null;
        public delegate void Update(JObject streamData);

        private void parseJson(string streamData)
        {
            JObject data = JObject.Parse(streamData);

            if (UpdateView != null)
            { UpdateView(data); }
        }
    }
}
