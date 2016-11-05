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

        public OutputView(Form1 parent)
        {
            this.parent = parent;
            InitializeComponent();
            this.Visible = false;
            listView1.Visible = false;
            //listView1.AutoResizeColumns(ColumnHeaderAutoResizeStyle.ColumnContent); ?

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

        public void updateOutput(JObject output)
        {
            listView1.View = View.Details;
            listView1.Columns.Add("Hoofdstuk").Width = 80;
            listView1.Columns.Add("Titel").Width = 75;
            listView1.Columns.Add("Text").Width = 300;
            listView1.Columns.Add("Category").Width = 75;
            
            for (int i = 0; i < output["law_articles"].Count(); i++)
            {
                ListViewItem item = new ListViewItem(new[] { output["law_articles"][i]["chapter"].ToString(), output["law_articles"][i]["article_title"].ToString(), output["law_articles"][i]["article_text"].ToString(), "this is dummy data" }); // Creat array item which will be added to a row of the listview
                listView1.Items.Add(item);  // Add the item
            }

            listView1.Visible = true;       // Show the listview
        }

        private void listView1_SelectedIndexChanged(object sender, EventArgs e)
        {
            // When selecting an item?
        }
    }
}
