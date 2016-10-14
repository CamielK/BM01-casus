using System;
using System.Net;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Newtonsoft.Json.Linq;
using System.Windows.Forms;
using System.IO;

namespace AiderApp
{
    public partial class Form1 : Form
    {
       

        public Form1()
        {
            //this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            InitializeComponent();
            panel1.Visible = false;
        }

        private void Form1_Load(object sender, EventArgs e)
        {

        }

        private void comboBox1_SelectedIndexChanged(object sender, EventArgs e)
        {

        }

        private void label1_Click(object sender, EventArgs e)
        {

        }

        private void label2_Click(object sender, EventArgs e)
        {

        }

        private void label3_Click(object sender, EventArgs e)
        {

        }

        private async void button1_Click(object sender, EventArgs e)
        {
            

            var requestUrl = "http://37.97.195.239/bm01/api.php/search/" + this.textBox1.Text;
            var httpWebRequest = (HttpWebRequest)WebRequest.Create(requestUrl);

            httpWebRequest.ContentType = "application/json; charset=utf8";
            httpWebRequest.Accept = "*/*";
            httpWebRequest.Method = "GET";

            using (var response = (HttpWebResponse)(await httpWebRequest.GetResponseAsync()))
            {
                using (var streamReader = new StreamReader(response.GetResponseStream()))
                {
                    string streamData = streamReader.ReadToEnd();

                    MessageBox.Show(streamData);

                    JObject data = JObject.Parse(streamData);

                    if (data["law_articles"] != null && data["law_articles"].Any())
                    {

                        label1.Text = data["law_articles"][1]["article_text"].ToString();

                        panel1.Visible = true;
                    }
                }
            }


        }

        private void button2_Click(object sender, EventArgs e)
        {
            Close();
        }

        private void listBox1_SelectedIndexChanged(object sender, EventArgs e)
        {

        }

        private void pictureBox1_Click(object sender, EventArgs e)
        {
            pictureBox1.SizeMode = PictureBoxSizeMode.CenterImage;
        }

        private void textBox1_TextChanged(object sender, EventArgs e)
        {

        }

        private void panel1_Paint(object sender, PaintEventArgs e)
        {

        }
    }
}
