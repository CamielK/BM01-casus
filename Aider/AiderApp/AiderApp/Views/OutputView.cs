using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using Newtonsoft.Json.Linq;

namespace AiderApp.Views
{
    public partial class OutputView : Form
    {
        Form1 parent;
        ArticleView av;
        JObject output;

        public OutputView(Form1 parent)
        {
            this.parent = parent;
            InitializeComponent();
            this.Visible = false;
            listView1.Visible = false;
            //listView1.AutoResizeColumns(ColumnHeaderAutoResizeStyle.ColumnContent); ?
            av = new ArticleView(this);

            resetLoadingMessage();
        }

        //go back to search view
        private void button1_Click(object sender, EventArgs e)
        {
            parent.Location = this.Location;
            this.Visible = false;
            parent.Visible = true;
        }

        //close application
        private void button2_Click(object sender, EventArgs e)
        {
            Close();
        }

        public void resetLoadingMessage()
        {
            outputLabel2.Text = "Finding an answer to your question.. this may take a while";
            outputLabel3.Text = "Finding an answer to your question.. this may take a while";
            outputLabel3.Visible = true;
            outputLabel2.Visible = true;
        }

        public void updateOutput(JObject output)
        {
            //display summary
            outputLabel2.Visible = false;
            String summary = "";
            for (int i = 0; i < output["summary_sentences"].Count(); i++)
            {
                summary += output["summary_sentences"][i];
            }
            answerOutputBox.Text = summary;



            //display sources
            listView1.View = View.Details;
            outputLabel3.Visible = false;

            //create sources list table headers
            listView1.Columns.Add("Hoofdstuk").Width = 100;
            listView1.Columns.Add("Titel").Width = 90;
            listView1.Columns.Add("Text").Width = 300;
            listView1.Columns.Add("Wetboek").Width = 150;
            
            //for each article returned from the backend, add an item to the sources list
            for (int i = 0; i < output["law_articles"].Count(); i++)
            {
                ListViewItem item = new ListViewItem(new[] { output["law_articles"][i]["chapter"].ToString(), output["law_articles"][i]["article_title"].ToString(), output["law_articles"][i]["article_text"].ToString(), output["law_articles"][i]["law_book"].ToString() }); // Creat array item which will be added to a row of the listview
                listView1.Items.Add(item);  // Add the item
            }
            listView1.Visible = true;       // Show the listview

            //save the output for future use (article views)
            this.output = output;
        }

        private void listView1_SelectedIndexChanged(object sender, EventArgs e)
        {
            if (listView1.SelectedIndices.Count != 0)
            {
                av.updateOutput(output, listView1.SelectedIndices[0]);
            }
        }

        private void outputLabel_Click(object sender, EventArgs e)
        {

        }

        private void label1_Click(object sender, EventArgs e)
        {

        }
    }
}
