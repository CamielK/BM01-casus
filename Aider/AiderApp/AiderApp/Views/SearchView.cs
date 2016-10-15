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
using AiderApp.Controllers;
using AiderApp.Views;

namespace AiderApp
{
    public partial class Form1 : Form
    {

        OutputView outputView;

        public Form1()
        {
            //this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            InitializeComponent();
            outputView = new OutputView(this);

        }

        private void Form1_Load(object sender, EventArgs e)
        {

        }

        private async void button1_Click(object sender, EventArgs e)
        {
            outputView.Location = this.Location;
            outputView.Visible = true;
            this.Visible = false;

            SearchController _controller = new SearchController();

            _controller.SearchLaws(this.textBox1.Text);
            _controller.UpdateView += delegate (JObject data)
            {
                if (data["law_articles"] != null && data["law_articles"].Any())
                {
                    
                    //TODO: dynamicly load json data into results table
                    //for (int i = 0; i < data["law_articles"].Count(); i++)
                    //{

                    //}

                    outputView.updateOutput(data["law_articles"][1]["article_text"].ToString());

                }
                else
                {
                    //if no results are found
                    MessageBox.Show("Geen resultaten gevonden, probeer een andere zoekopdracht!");
                }
            };

        }

        private void button2_Click(object sender, EventArgs e)
        {
            Close();
        }
    }
}
