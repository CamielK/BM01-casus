namespace AiderApp.Views
{
    partial class OutputView
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(OutputView));
            this.panel1 = new System.Windows.Forms.Panel();
            this.outputLabel2 = new System.Windows.Forms.Label();
            this.answerOutputBox = new System.Windows.Forms.TextBox();
            this.outputLabel3 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.label1 = new System.Windows.Forms.Label();
            this.listView1 = new System.Windows.Forms.ListView();
            this.button2 = new System.Windows.Forms.Button();
            this.button1 = new System.Windows.Forms.Button();
            this.panel1.SuspendLayout();
            this.SuspendLayout();
            // 
            // panel1
            // 
            this.panel1.Controls.Add(this.outputLabel2);
            this.panel1.Controls.Add(this.answerOutputBox);
            this.panel1.Controls.Add(this.outputLabel3);
            this.panel1.Controls.Add(this.label2);
            this.panel1.Controls.Add(this.label1);
            this.panel1.Controls.Add(this.listView1);
            this.panel1.Location = new System.Drawing.Point(10, 45);
            this.panel1.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(568, 476);
            this.panel1.TabIndex = 1;
            // 
            // outputLabel2
            // 
            this.outputLabel2.Location = new System.Drawing.Point(140, 124);
            this.outputLabel2.Margin = new System.Windows.Forms.Padding(2, 0, 2, 0);
            this.outputLabel2.Name = "outputLabel2";
            this.outputLabel2.Size = new System.Drawing.Size(287, 15);
            this.outputLabel2.TabIndex = 11;
            this.outputLabel2.Text = "Finding an answer to your question.. this may take a while";
            // 
            // answerOutputBox
            // 
            this.answerOutputBox.Location = new System.Drawing.Point(0, 16);
            this.answerOutputBox.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.answerOutputBox.Multiline = true;
            this.answerOutputBox.Name = "answerOutputBox";
            this.answerOutputBox.ReadOnly = true;
            this.answerOutputBox.ScrollBars = System.Windows.Forms.ScrollBars.Vertical;
            this.answerOutputBox.Size = new System.Drawing.Size(568, 233);
            this.answerOutputBox.TabIndex = 10;
            // 
            // outputLabel3
            // 
            this.outputLabel3.Location = new System.Drawing.Point(140, 367);
            this.outputLabel3.Margin = new System.Windows.Forms.Padding(2, 0, 2, 0);
            this.outputLabel3.Name = "outputLabel3";
            this.outputLabel3.Size = new System.Drawing.Size(287, 15);
            this.outputLabel3.TabIndex = 6;
            this.outputLabel3.Text = "Finding an answer to your question.. this may take a while";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(2, 251);
            this.label2.Margin = new System.Windows.Forms.Padding(2, 0, 2, 0);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(130, 13);
            this.label2.TabIndex = 5;
            this.label2.Text = "Sources (click to expand):";
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(2, 0);
            this.label1.Margin = new System.Windows.Forms.Padding(2, 0, 2, 0);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(45, 13);
            this.label1.TabIndex = 4;
            this.label1.Text = "Answer:";
            this.label1.Click += new System.EventHandler(this.label1_Click);
            // 
            // listView1
            // 
            this.listView1.Location = new System.Drawing.Point(0, 268);
            this.listView1.MultiSelect = false;
            this.listView1.Name = "listView1";
            this.listView1.Size = new System.Drawing.Size(568, 211);
            this.listView1.TabIndex = 1;
            this.listView1.UseCompatibleStateImageBehavior = false;
            this.listView1.SelectedIndexChanged += new System.EventHandler(this.listView1_SelectedIndexChanged);
            // 
            // button2
            // 
            this.button2.Location = new System.Drawing.Point(120, 10);
            this.button2.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.button2.Name = "button2";
            this.button2.Size = new System.Drawing.Size(106, 29);
            this.button2.TabIndex = 2;
            this.button2.Text = "Afsluiten";
            this.button2.UseVisualStyleBackColor = true;
            this.button2.Click += new System.EventHandler(this.button2_Click);
            // 
            // button1
            // 
            this.button1.Location = new System.Drawing.Point(10, 10);
            this.button1.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.button1.Name = "button1";
            this.button1.Size = new System.Drawing.Size(106, 29);
            this.button1.TabIndex = 3;
            this.button1.Text = "Opnieuw zoeken";
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new System.EventHandler(this.button1_Click);
            // 
            // OutputView
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(587, 535);
            this.Controls.Add(this.button1);
            this.Controls.Add(this.button2);
            this.Controls.Add(this.panel1);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Location = new System.Drawing.Point(100, 100);
            this.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.MaximumSize = new System.Drawing.Size(603, 574);
            this.MinimumSize = new System.Drawing.Size(603, 574);
            this.Name = "OutputView";
            this.StartPosition = System.Windows.Forms.FormStartPosition.Manual;
            this.Text = "Aider output";
            this.panel1.ResumeLayout(false);
            this.panel1.PerformLayout();
            this.ResumeLayout(false);

        }

        #endregion
        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.Button button2;
        private System.Windows.Forms.Button button1;
        private System.Windows.Forms.ListView listView1;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label outputLabel3;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.Label outputLabel2;
        private System.Windows.Forms.TextBox answerOutputBox;
    }
}