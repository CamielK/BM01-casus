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

            SearchController _controller = new SearchController();

            _controller.SearchLaws(this.textBox1.Text);
            _controller.UpdateView += delegate (JObject data)
            {
                if (data["law_articles"] != null && data["law_articles"].Any())
                {
                    //MessageBox.Show(data["law_articles"][1]["article_text"].ToString());

                    //TODO: dynamicly load json data into results table
                    label1.Text = data["law_articles"][1]["article_text"].ToString();
                    panel1.Visible = true;
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
