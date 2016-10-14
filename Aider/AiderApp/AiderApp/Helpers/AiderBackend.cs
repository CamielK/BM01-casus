using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

namespace AiderApp.Helpers
{
    class AiderBackend
    {
        public event GetJson JsonHandler = null;
        public delegate void GetJson(string streamData);

        public async void GetAiderData(string url)
        {
            var requestUrl = "http://37.97.195.239/bm01/api.php/" + url;
            var httpWebRequest = (HttpWebRequest)WebRequest.Create(requestUrl);

            httpWebRequest.ContentType = "application/json; charset=utf8";
            httpWebRequest.Accept = "*/*";
            httpWebRequest.Method = "GET";

            using (var response = (HttpWebResponse)(await httpWebRequest.GetResponseAsync()))
            {
                using (var streamReader = new StreamReader(response.GetResponseStream()))
                {
                    string streamData = streamReader.ReadToEnd();

                    if (JsonHandler != null)
                    {
                        JsonHandler(streamData);
                    }
                }
            }
        }


        public async void PostAiderData(string url, Dictionary<string, string> data)
        {
            HttpClient httpClient = new HttpClient();

            try
            {
                string uri = "http://37.97.195.239/bm01/api.php/" + url;

                FormUrlEncodedContent content = new FormUrlEncodedContent(data);
                HttpResponseMessage response = null;
                response = await httpClient.PostAsync(uri, content);

                /*
                if (response.IsSuccessStatusCode)
                {
                    // Can be used to get a success or error value from API.
                }
                */
            }
            catch (Exception ex)
            {

            }
        }

    }
}
