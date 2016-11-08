using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace AiderApp.Views
{
    public partial class ArticleView : Form
    {
        Form parent;

        public ArticleView(Form parent)
        {
            this.parent = parent;
            InitializeComponent();
            this.Visible = false;
        }

        public void updateOutput(JObject output, int i)
        {
            label1.Text = output["law_articles"][i]["chapter"].ToString();
            label2.Text = output["law_articles"][i]["article_title"].ToString();
            textBox1.Text = output["law_articles"][i]["article_text"].ToString();
            this.Visible = true;
            this.TopMost = true;
            this.Activate();
        }

        private void button1_Click_1(object sender, EventArgs e)
        {
            this.Visible = false;
            this.Hide();
        }

        private void ArticleView_FormClosing(object sender, FormClosingEventArgs e)
        {
            this.Visible = false;
            this.Hide();
            e.Cancel = true;
        }
    }
}
