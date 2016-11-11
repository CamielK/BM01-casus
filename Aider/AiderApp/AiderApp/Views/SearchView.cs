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
            //this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;     // Uncomment this to disable the windows menu bar
            InitializeComponent();

            //default checkboxes to true (opt out structure)
            for (int i = 0; i < checkedListBox1.Items.Count; i++)
            {
                checkedListBox1.SetItemChecked(i, true);
            }
        }

        private void Form1_Load(object sender, EventArgs e)
        { }

        private void comboBox1_SelectedIndexChanged(object sender, EventArgs e)
        { }

        private void label1_Click(object sender, EventArgs e)
        { }

        private void label2_Click(object sender, EventArgs e)
        { }

        private void label3_Click(object sender, EventArgs e)
        { }

        private async void button1_Click(object sender, EventArgs e)
        {
            outputView = new OutputView(this);
            outputView.Location = this.Location;
            outputView.Visible = true;
            this.Visible = false;

            //Use this to show which options have been checked
            string categoryList = "";
            for (int x = 0; x <= checkedListBox1.CheckedItems.Count - 1; x++)
            {
                categoryList = categoryList + "+" + checkedListBox1.CheckedItems[x].ToString();
            }


            //else    // If none of the boxes are checked
            //{ MessageBox.Show("Kies minstens een categorie!"); }

            SearchController _controller = new SearchController();
            _controller.SearchLaws(this.textBox1.Text + "/" + categoryList);           
            _controller.UpdateView += delegate (JObject data)     
            {
                if (data["law_articles"] != null && data["law_articles"].Any())
                {
                    //send search result to output view
                    outputView.updateOutput(data);
                }
                else    // if no results are found
                { MessageBox.Show("Geen resultaten gevonden, probeer een andere zoekopdracht!"); }
            };
        }

        private void button2_Click(object sender, EventArgs e)
        { Close(); }    // Close Aider

        private void listBox1_SelectedIndexChanged(object sender, EventArgs e)
        { }

        private void pictureBox1_Click(object sender, EventArgs e)
        { pictureBox1.SizeMode = PictureBoxSizeMode.CenterImage; }

        private void textBox1_TextChanged(object sender, EventArgs e)
        { }

        private void panel1_Paint(object sender, PaintEventArgs e)
        { }

        private void textBox1_KeyUp(object sender, KeyEventArgs e)
        {
            if (e.KeyCode == Keys.Enter)
            {
                button1.PerformClick();
                e.Handled = true;
            }
            else if (e.KeyCode == Keys.Escape)
            {
                Close();
                e.Handled = true;
            }
        }

        private void label3_Click_1(object sender, EventArgs e)
        {

        }

        private void checkedListBox1_SelectedIndexChanged(object sender, EventArgs e)
        {

        }

        private void label2_Click_1(object sender, EventArgs e)
        {

        }
    }
}
