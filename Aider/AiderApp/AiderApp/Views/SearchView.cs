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

            // Use this to show which options have been checked
            //string s = "";
            //for (int x = 0; x <= checkedListBox1.CheckedItems.Count - 1; x++)
            //{ s = s + "Checked Item " + (x + 1).ToString() + " = " + checkedListBox1.CheckedItems[x].ToString() + "\n"; }
            //MessageBox.Show(s);

            // TODO: Find a proper way to handle the case of multiple checked checkboxes
            if (checkedListBox1.CheckedItems.Count == 3)
            { } // Search in all categories

            else if (checkedListBox1.CheckedItems.Count == 2)    // If two options are checked
            {
                if (checkedListBox1.GetItemChecked(0) && (checkedListBox1.GetItemChecked(1)))
                { } // Search in those 2 categories

                if (checkedListBox1.GetItemChecked(1) && (checkedListBox1.GetItemChecked(2)))
                { } // Search in those 2 categories


                if (checkedListBox1.GetItemChecked(0) && (checkedListBox1.GetItemChecked(2)))
                { } // Search in those 2 categories
            }

            else if (checkedListBox1.CheckedItems.Count == 1)    // if just one box is checked
            {
                if (checkedListBox1.GetItemChecked(0))
                {
                    MessageBox.Show("Option 1 was checked");
                    // Search in that category
                }

                if (checkedListBox1.GetItemChecked(1))
                {
                    MessageBox.Show("Option 2 was checked");
                    // Search in that category
                }

                if (checkedListBox1.GetItemChecked(2))
                {
                    MessageBox.Show("Option 3 was checked");
                    // Search in that category
                }
            }

            else    // If none of the boxes are checked
            { MessageBox.Show("Kies een categorie!"); }

            SearchController _controller = new SearchController();      // What is this?
            _controller.SearchLaws(this.textBox1.Text);                 // What is this?
            _controller.UpdateView += delegate (JObject data)           // What is this?
            {
                if (data["law_articles"] != null && data["law_articles"].Any())
                {
                    //TODO: dynamicly load json data into results table
                    //for (int i = 0; i < data["law_articles"].Count(); i++)
                    //{
                    //  insert it into table row
                    //}

                    outputView.updateOutput(data.ToString());
                    // outputView.updateOutput(data["law_articles"][1]["article_text"].ToString());
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
    }
}
